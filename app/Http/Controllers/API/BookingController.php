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


    public function getBookingHistory(Request $request)
    {
        try {
            $user = $request->user();

            $bookings = $this->bookingService->getBookingHistory($user);

            return $this->sendResponse($bookings, 'Booking history fetched successfully.');
        } catch (\Throwable $e) {
            return $this->sendError(
                'Something went wrong.',
                [
                    'exception' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                ],
                500
            );
        }
    }



    public function submitBooking(CheckoutRequest $request)
    {
        try {
            $this->bookingService->createBooking($request->validated());


            return $this->sendResponse([], 'Booking submitted successfully!');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
