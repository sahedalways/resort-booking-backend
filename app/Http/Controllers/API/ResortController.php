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
                        ->select('id', 'resort_id', 'name', 'price', 'bed_type_id', 'area', 'view_type_id', 'adult_cap', 'child_cap', 'package_name', 'desc', 'is_active')
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
}
