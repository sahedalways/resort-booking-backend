<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'resort_id',
        'name',
        'bed_type_id',
        'area',
        'view_type_id',
        'price',
        'adult_cap',
        'child_cap',
        'price_per',
        'package_name',
        'desc',
        'is_active',
    ];

    public function resort()
    {
        return $this->belongsTo(Resort::class);
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }

    public function bedType()
    {
        return $this->belongsTo(RoomBedType::class, 'bed_type_id');
    }

    public function viewType()
    {
        return $this->belongsTo(RoomViewType::class, 'view_type_id');
    }

    public function services()
    {
        return $this->hasMany(RoomServiceInfo::class);
    }

    public function rateDetails()
    {
        return $this->hasMany(RoomRateDetail::class, 'room_id');
    }
}
