<?php

namespace App\Livewire\Backend\BookingInfo;

use App\Livewire\Backend\Components\BaseComponent;

class ConfirmBooking extends BaseComponent
{
    public $search;
    public $expandedRows = [];

    public function render()
    {
        return view('livewire.backend.booking-info.confirm-booking');
    }
}
