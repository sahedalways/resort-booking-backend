<?php

namespace App\Livewire\Backend\BookingInfo;

use App\Livewire\Backend\Components\BaseComponent;

class CompletedBooking extends BaseComponent
{
    public function render()
    {
        return view('livewire.backend.booking-info.completed-booking');
    }
}
