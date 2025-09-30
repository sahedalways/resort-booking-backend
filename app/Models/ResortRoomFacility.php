<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResortRoomFacility extends Model
{
    protected $fillable = ['name', 'icon'];

    public function options()
    {
        return $this->hasMany(ResortRoomFacilityOption::class, 'facility_id', 'id');
    }
}
