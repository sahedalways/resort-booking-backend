<?php

namespace App\Http\Controllers\API;

use App\Models\EventHero;
use App\Models\EventService;
use Illuminate\Http\Request;



class EventController extends BaseController
{

    public function getEventData(Request $request)
    {
        try {
            $eventTopInfo = EventHero::select('id', 'title', 'sub_title', 'hero_image', 'phone_number')
                ->first();


            $eventServices = EventService::with(['images'])
                ->select('id', 'title', 'description')
                ->latest()
                ->get();


            $eventServices->transform(function ($service) {
                $service->thumbnail_url = $service->thumbnail
                    ? getFileUrlForFrontend($service->thumbnail)
                    : asset('assets/img/default-image.jpg');

                $service->images->transform(function ($image) {
                    return [
                        'id' => $image->id,
                        'image' => getFileUrlForFrontend($image->image),
                    ];
                });

                return $service;
            });

            return response()->json([
                'success' => true,
                'message' => 'Event data fetched successfully',
                'data' => [
                    'event_top_info' => $eventTopInfo,
                    'event_services' => $eventServices,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch event data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
