<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResortFacilityOptionService extends Model
{
    protected $fillable = [
        'resort_id',
        'facility_id',
        'type_name',
        'icon',
    ];

    // Resort relation
    public function resort()
    {
        return $this->belongsTo(Resort::class, 'resort_id');
    }

    // Facility relation
    public function facility()
    {
        return $this->belongsTo(ResortRoomFacility::class, 'facility_id');
    }
}
