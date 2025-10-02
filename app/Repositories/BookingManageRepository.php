<?php

namespace App\Repositories;

use App\Models\BookingInfo;


class BookingManageRepository
{

  public function getSingleBookingInfo($id): BookingInfo
  {
    return BookingInfo::where('id', $id)->first();
  }



  public function deleteItem(int $id)
  {
    $data = $this->getSingleBookingInfo($id);
    $data->delete();
  }





  public function searchBooking($search = null, $status = null)
  {
    $query = BookingInfo::query();

    if ($status) {
      $query->where('status', $status);
    }

    if ($search && $search != '') {
      $query->where(function ($q) use ($search) {

        // Search in user
        $q->whereHas('user', function ($q2) use ($search) {
          $q2->where('f_name', 'like', '%' . $search . '%')
            ->orWhere('l_name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
        });

        // Search in resort
        $q->orWhereHas('resort', function ($q3) use ($search) {
          $q3->where('name', 'like', '%' . $search . '%');
        });

        // Search in room
        $q->orWhereHas('room', function ($q4) use ($search) {
          $q4->where('name', 'like', '%' . $search . '%');
        });
      });
    }

    return $query;
  }
}
