<?php

namespace App\Services\API\Booking;


use App\Repositories\API\Booking\BookingRepository;

class BookingService
{
  protected BookingRepository $repository;

  public function __construct(BookingRepository $repository)
  {
    $this->repository = $repository;
  }



  public function getBookingHistory($user)
  {
    return $this->repository->getBookingHistory($user);
  }
}
