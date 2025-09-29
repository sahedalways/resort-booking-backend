<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_value',
        'status',
    ];


    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
}
