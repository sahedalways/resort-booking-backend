<?php

namespace App\Services;

use App\Repositories\BookingManageRepository;



class BookingManageService
{
  protected $repository;

  public function __construct(BookingManageRepository $repository)
  {
    $this->repository = $repository;
  }


  public function deleteItem($id)
  {

    return $this->repository->deleteItem($id);
  }



  public function findBooking($id)
  {

    return $this->repository->getSingleBookingInfo($id);
  }


  public function searchBooking($search = null, $status = null)
  {

    return $this->repository->searchBooking($search, $status);
  }
}
