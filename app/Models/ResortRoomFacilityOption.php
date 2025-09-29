<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResortRoomFacilityOption extends Model
{
    protected $fillable = ['facility_id', 'name'];

    public function facility()
    {
        return $this->belongsTo(ResortRoomFacility::class, 'facility_id');
    }
}
