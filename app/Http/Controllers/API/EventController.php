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


            $eventServices = EventService::select('id', 'title', 'description', 'thumbnail')
                ->latest()
                ->get();


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




    public function getSingleEventData($id)
    {
        try {
            $eventService = EventService::with(['images'])
                ->select('id', 'title', 'description', 'thumbnail')
                ->findOrFail($id);

            // Transform thumbnail
            $eventService->thumbnail_url = $eventService->thumbnail
                ? getFileUrlForFrontend($eventService->thumbnail)
                : asset('assets/img/default-image.jpg');

            // Transform images
            $eventService->images->transform(function ($image) {
                return [
                    'id' => $image->id,
                    'image' => getFileUrlForFrontend($image->image),
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Single event service data fetched successfully',
                'data' => $eventService,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Event service not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch event service data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
