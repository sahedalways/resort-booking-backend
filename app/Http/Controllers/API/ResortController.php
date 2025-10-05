<?php

namespace App\Http\Controllers\API;

use App\Models\Resort;
use Illuminate\Http\Request;



class ResortController extends BaseController
{

    public function getResortData(Request $request)
    {
        try {
            $perPage = 5;

            $resorts = Resort::select('id', 'name', 'location', 'distance', 'package_id')
                ->with([
                    'images:id,resort_id,image',
                    'packageType',
                    'facilities',
                    'facilities.facility',
                ])
                ->where('is_active', true)
                ->latest()
                ->paginate($perPage);


            $resorts->getCollection()->transform(function ($resort) {
                // Images
                $resort->images->transform(fn($image) => getFileUrlForFrontend($image->image));


                $grouped = $resort->facilities->groupBy('facility_id');

                $resort->facilities = $grouped->map(function ($services, $facilityId) {
                    $parent = $services->first()->facility;

                    return [
                        'name' => $parent->name ?? 'No Facility',
                        'icon' => $parent->icon ?? null,
                        'services' => $services->map(function ($service) {
                            return [
                                'type_name' => $service->type_name,
                                'icon' => $service->icon,
                            ];
                        })->values(),
                    ];
                })->values();



                // Package type
                $resort->package_type = $resort->packageType ? [
                    'icon' => $resort->packageType->icon,
                    'type_name' => $resort->packageType->type_name,
                    'is_refundable' => (bool) $resort->packageType->is_refundable,
                ] : null;

                unset($resort->packageType);

                // Lowest price
                $resort->lowest_price = $resort->lowestRoomPrice();

                return $resort;
            });

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
                'rooms' => function ($query) {
                    $query->where('is_active', true)
                        ->select(
                            'id',
                            'resort_id',
                            'name',
                            'price',
                            'bed_type_id',
                            'area',
                            'view_type_id',
                            'adult_cap',
                            'child_cap',
                            'package_name',
                            'desc',
                            'is_active'
                        )
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

            // Resort images → full URL
            $resort->images->transform(fn($image) => getFileUrlForFrontend($image->image));



            $grouped = $resort->facilities->groupBy('facility_id');

            $resort->facilities = $grouped->map(function ($services, $facilityId) {
                $parent = $services->first()->facility;

                return [
                    'name' => $parent->name ?? 'No Facility',
                    'icon' => $parent->icon ?? null,
                    'services' => $services->map(function ($service) {
                        return [
                            'type_name' => $service->type_name,
                            'icon' => $service->icon,
                        ];
                    })->values(),
                ];
            })->values();


            // Package type → icon, type_name, is_refundable
            $resort->package_type = $resort->packageType ? [
                'icon' => $resort->packageType->icon,
                'type_name' => $resort->packageType->type_name,
                'is_refundable' => (bool) $resort->packageType->is_refundable,
            ] : null;


            unset($resort->packageType);



            // Rooms → transform data
            $resort->rooms->transform(function ($room) {
                // Room images → full URL
                $room->images->transform(fn($image) => getFileUrlForFrontend($image->image));

                // Services → name & icon
                $room->services->transform(fn($service) => [
                    'name' => $service->service->type_name ?? $service->type_name,
                    'icon' => $service->service->icon ?? $service->icon,
                ]);

                // RateDetails → only id, room_id, title, is_active
                $room->rateDetails->transform(fn($rate) => [
                    'id' => $rate->id,
                    'room_id' => $rate->room_id,
                    'title' => $rate->title,
                    'is_active' => (bool)$rate->is_active,
                ]);

                return $room;
            });



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
}
