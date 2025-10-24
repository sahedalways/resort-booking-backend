<?php

namespace App\Jobs;

use App\Models\BookingInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBookingInfoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected BookingInfo $booking;

    public function __construct(BookingInfo $booking)
    {
        $this->booking = $booking;
    }

    public function handle(): void
    {
        $siteEmail = getSiteEmail();

        $user = $this->booking->user;
        $resort = $this->booking->resort;
        $room = $this->booking->room;

        if (!$siteEmail) return;

        Mail::send('mail.bookingInfo', [
            'user'    => $user,
            'resort'  => $resort,
            'room'    => $room,
            'booking' => $this->booking,
        ], function ($message) use ($siteEmail) {
            $message->to($siteEmail)
                ->subject('New Booking Received');
        });
    }
}
