<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResortFacilityOptionService extends Model
{
    protected $fillable = [
        'service_id',
        'option_id',
        'facility_id',
        'resort_id',
    ];



    public function options()
    {
        return $this->hasMany(ResortRoomFacilityOption::class, 'facility_id');
    }
}
