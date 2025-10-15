<?php

namespace App\Services\API\Booking;


use App\Repositories\API\Booking\BookingRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class BookingService
{
  protected BookingRepository $repository;

  public function __construct(BookingRepository $repository)
  {
    $this->repository = $repository;
  }


  public function createBooking(array $data)
  {
    DB::beginTransaction();

    try {
      $userId = Auth::id();

      $data['user_id'] = $userId;
      $data['status'] = 'pending';

      $booking = $this->repository->store($data);

      DB::commit();

      return $booking;
    } catch (Exception $e) {
      DB::rollBack();
      throw new Exception("Booking could not be processed: " . $e->getMessage());
    }
  }



  public function getBookingStatus($bookingId)
  {
    $booking = $this->repository->findById($bookingId);

    if (!$booking) {
      return null;
    }

    return $booking;
  }
}
