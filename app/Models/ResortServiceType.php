<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResortServiceType extends Model
{
    protected $fillable = [
        'type_name',
        'icon',
    ];


    public function options()
    {
        return $this->hasMany(ResortRoomFacilityOption::class, 'service_id');
    }
}
