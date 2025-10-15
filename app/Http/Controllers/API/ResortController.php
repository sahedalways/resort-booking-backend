<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\SearchResortRequest;
use App\Models\Resort;
use Illuminate\Http\Request;



class ResortController extends BaseController
{

    public function getResortData(Request $request)
    {
        try {
            $perPage = 5;
            $resorts = Resort::with([
                'images' => function ($query) {
                    $query->select('id', 'resort_id', 'image')
                        ->orderBy('id', 'asc')
                        ->limit(1);
                },
                'packageType:id,icon,type_name,is_refundable',
                'facilities:id,type_name,icon,resort_id,facility_id',
                'facilities.facility:id,name,icon',
            ])
                ->where('is_active', true)
                ->latest()
                ->paginate($perPage);

            $resorts->getCollection()->transform(fn($resort) => $resort->transformForApiAllResorts());



            return response()->json([
                'success' => true,
                'message' => 'Resort data fetched successfully',
                'data' => [
                    'resort_info' => $resorts->items(),
                    'pagination' => [
                        'current_page' => $resorts->currentPage(),
                        'last_page' => $resorts->lastPage(),
                        'per_page' => $resorts->perPage(),
                        'total' => $resorts->total(),
                    ],
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch resort data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function getSingleResortData($id)
    {
        try {
            $resort = Resort::with([
                'images:id,resort_id,image',
                'packageType',
                'facilities',
                'facilities.facility',
                'additionalFacts',
                'rooms' => function ($query) {
                    $query->where('is_active', true)
                        ->select('id', 'resort_id', 'name', 'price', 'bed_type_id', 'area', 'view_type_id', 'adult_cap', 'child_cap', 'package_name', 'desc', 'is_active', 'is_daylong')
                        ->with([
                            'images:id,room_id,image',
                            'bedType:id,type_name',
                            'viewType:id,type_name',
                            'services.service:id,type_name,icon',
                            'rateDetails:id,room_id,title,is_active'
                        ]);
                }
            ])
                ->where('is_active', true)
                ->findOrFail($id);

            $resort->transformForApiForSingleResort();



            return response()->json([
                'success' => true,
                'message' => 'Single resort data fetched successfully',
                'data' => $resort
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Resort not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch resort data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }




    public function searchResort(SearchResortRequest $request)
    {
        try {
            $resortId = $request->resort_id;
            $requestedRooms = json_decode($request->rooms, true);
            $checkIn = $request->check_in;
            $checkOut = $request->check_out;

            $resort = Resort::with([
                'images' => function ($query) {
                    $query->select('id', 'resort_id', 'image')
                        ->orderBy('id', 'asc');
                },
                'rooms' => function ($query) use ($requestedRooms, $resortId, $checkIn, $checkOut) {
                    $query->where('is_active', true)
                        ->select('id', 'resort_id', 'name', 'price', 'bed_type_id', 'area', 'view_type_id', 'adult_cap', 'child_cap', 'package_name', 'desc', 'is_active', 'is_daylong')
                        ->with([
                            'images:id,room_id,image',
                            'bedType:id,type_name',
                            'viewType:id,type_name',
                            'services.service:id,type_name,icon',
                            'rateDetails:id,room_id,title,is_active'
                        ])
                        ->where(function ($q) use ($requestedRooms) {
                            foreach ($requestedRooms as $room) {
                                $adults = $room['adults'];
                                $children = $room['children'] ?? 0;

                                $q->orWhere(function ($sub) use ($adults, $children) {
                                    $sub->where('adult_cap', '>=', $adults)
                                        ->where('child_cap', '>=', $children);
                                });
                            }
                        })
                        // Check availability in booking_infos
                        ->whereDoesntHave('bookings', function ($bq) use ($checkIn, $checkOut) {
                            $bq->where('status', 'confirmed')
                                ->where(function ($dateQuery) use ($checkIn, $checkOut) {
                                    $dateQuery->whereBetween('start_date', [$checkIn, $checkOut])
                                        ->orWhereBetween('end_date', [$checkIn, $checkOut])
                                        ->orWhere(function ($q) use ($checkIn, $checkOut) {
                                            $q->where('start_date', '<=', $checkIn)
                                                ->where('end_date', '>=', $checkOut);
                                        });
                                });
                        });
                },
                'packageType:id,icon,type_name,is_refundable',
                'facilities:id,type_name,icon,resort_id,facility_id',
                'facilities.facility:id,name,icon',
            ])
                ->where('id', $resortId)
                ->where('is_active', true)
                ->first();

            if ($resort) {
                // Check if rooms are available
                if ($resort->rooms->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No rooms available for the selected dates and guests.'
                    ]);
                }

                $resort = $resort->transformForApiForSingleResort();
                return response()->json([
                    'success' => true,
                    'data' => $resort,
                    'message' => 'Resort found successfully.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Resort not found.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search resort rooms',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
