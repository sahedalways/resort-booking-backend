<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'date_of_function',
        'gathering_size',
        'preferred_location',
        'budget',
        'message',
    ];
}
