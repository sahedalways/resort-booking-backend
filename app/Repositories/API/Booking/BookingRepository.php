<?php

namespace App\Repositories\API\Booking;

use App\Jobs\SendBookingInfoJob;
use App\Models\BookingInfo;
use App\Models\User;

class BookingRepository
{
  /**
   * Get booking history for a user
   */
  public function getBookingHistory(User $user)
  {
    return $user->bookings()
      ->with('resort', 'room')
      ->orderBy('created_at', 'desc')
      ->get();
  }



  public function store(array $data)
  {
    $booking = BookingInfo::create([
      'user_id'       => $data['user_id'],
      'resort_id'     => $data['resort_id'],
      'room_id'       => $data['room_id'],
      'booking_for'   => $data['booking_for'],
      'adult'         => $data['adult'],
      'child'         => $data['child'] ?? 0,
      'start_date' => isset($data['start_date']) ? date('Y-m-d', strtotime($data['start_date'])) : null,
      'end_date'   => isset($data['end_date']) ? date('Y-m-d', strtotime($data['end_date'])) : null,
      'amount'        => $data['amount'],
      'is_used_coupon' => $data['is_used_coupon'],
      'additional_comment'       => $data['comment'] ?? null,
      'status'        => $data['status'],
    ]);


    // dispatch(new SendBookingInfoJob($booking));

    return $booking;
  }



  public function findById($id)
  {
    $booking = BookingInfo::find($id);

    if (!$booking) {
      return null;
    }

    // If status is pending, mark it as cancelled
    if ($booking->status === 'pending') {
      $booking->status = 'cancelled';
      $booking->save();
    }

    return $booking;
  }
}
