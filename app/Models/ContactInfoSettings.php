<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInfoSettings extends Model
{
    protected $fillable = [
        'email',
        'phone',
        'dhaka_office_address',
        'gazipur_office_address',
    ];
}
