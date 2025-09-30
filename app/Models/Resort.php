<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    protected $fillable = ['name', 'distance', 'location', 'desc', 'd_check_in', 'd_check_out', 'n_check_in', 'n_check_out', 'package_id'];


    public function images()
    {
        return $this->hasMany(ResortImage::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function additionalFacts()
    {
        return $this->hasMany(ResortAdditionalFact::class);
    }

    public function packageType()
    {
        return $this->belongsTo(ResortPackageType::class, 'package_id');
    }


    public function facilities()
    {
        return $this->belongsToMany(
            ResortRoomFacility::class,
            'resort_facility_option_services',
            'resort_id',
            'facility_id'
        )->withPivot('option_id', 'service_id')
            ->withTimestamps();
    }
}
