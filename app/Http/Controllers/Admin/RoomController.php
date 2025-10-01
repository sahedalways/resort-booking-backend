<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\API\BaseController;
use App\Models\Room;



class RoomController extends BaseController
{
    public function show($id)
    {
        $room = Room::with(['images', 'resort', 'bedType', 'viewType', 'services.service', 'rateDetails'])->findOrFail($id);


        return view('livewire.backend.manage-room.show', compact('room'));
    }
}
