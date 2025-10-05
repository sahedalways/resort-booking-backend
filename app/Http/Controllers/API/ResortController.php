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

                // Facilities
                $resort->facilities->transform(fn($facility) => [
                    'name' => $facility->facility->name ?? $facility->type_name,
                    'icon' => $facility->facility->icon ?? $facility->icon,
                ]);

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
}
