<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResortRoomFacilityOption extends Model
{
    protected $fillable = ['facility_id', 'service_id'];

    public function facility()
    {
        return $this->belongsTo(ResortRoomFacility::class, 'facility_id', 'id');
    }


    public function service()
    {
        return $this->belongsTo(ResortServiceType::class, 'service_id', 'id');
    }
}
