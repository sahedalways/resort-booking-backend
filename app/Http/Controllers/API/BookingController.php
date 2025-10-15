<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Booking\CheckoutRequest;
use App\Services\API\Booking\BookingService;
use Illuminate\Http\Request;

class BookingController extends BaseController
{
    protected BookingService $bookingService;


    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }


    public function submitBooking(CheckoutRequest $request)
    {
        try {
            $booking = $this->bookingService->createBooking($request->validated());


            return $this->sendResponse(['booking_id' => $booking->id,], 'Booking submitted successfully!');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function getStatus($bookingId, Request $request)
    {
        $booking = $this->bookingService->getBookingStatus($bookingId);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found',
            ], 404);
        }



        return $this->sendResponse(['booking' => $booking], 'Status fetched done.');
    }
}
