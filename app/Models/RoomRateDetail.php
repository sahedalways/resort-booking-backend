<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomRateDetail extends Model
{


    protected $fillable = [
        'room_id',
        'title',
        'is_active',
    ];

    /**
     * Each rate detail belongs to a Room
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
