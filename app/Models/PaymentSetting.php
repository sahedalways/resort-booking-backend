<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = [
        'gateway',
        'app_key',
        'app_secret',
        'username',
        'password',
        'base_url',
        'is_active',
    ];



    protected $casts = [
        'app_key'    => 'encrypted',
        'app_secret' => 'encrypted',
        'username'   => 'encrypted',
        'password'   => 'encrypted',
    ];
}