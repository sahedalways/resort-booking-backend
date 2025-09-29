<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResortPackageType extends Model
{
    protected $fillable = ['icon', 'type_name', 'is_refundable'];
}
