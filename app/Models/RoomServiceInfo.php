<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomServiceInfo extends Model
{
    protected $fillable = ['room_id', 'service_id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function service()
    {
        return $this->belongsTo(ResortServiceType::class, 'service_id');
    }
}
