<?php

namespace App\Repositories\API\Booking;

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
}
