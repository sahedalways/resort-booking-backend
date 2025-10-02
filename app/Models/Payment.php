<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'booking_id',
        'amount',
        'currency',
        'payment_method',
        'transaction_id',
        'status',
        'notes',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function booking()
    {
        return $this->belongsTo(BookingInfo::class);
    }
}
