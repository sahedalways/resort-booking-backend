<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingInfo extends Model
{
    protected $table = 'booking_infos';

    protected $fillable = [
        'resort_id',
        'room_id',
        'user_id',
        'status',
        'amount',
        'start_date',
        'end_date',
        'booking_for',
        'additional_comment',
        'is_used_coupon',
        'adult',
        'child',
        'invoice',
    ];



    // Relations
    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
