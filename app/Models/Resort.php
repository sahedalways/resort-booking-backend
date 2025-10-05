<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    protected $fillable = ['name', 'distance', 'location', 'desc', 'd_check_in', 'd_check_out', 'n_check_in', 'n_check_out', 'package_id', 'is_active'];


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
        return $this->hasMany(ResortAdditionalFact::class)->select('id', 'name', 'resort_id');
    }

    public function packageType()
    {
        return $this->belongsTo(ResortPackageType::class, 'package_id');
    }


    public function facilities()
    {
        return $this->hasMany(ResortFacilityOptionService::class, 'resort_id', 'id')->select('id', 'type_name', 'icon', 'facility_id', 'resort_id');
    }

    public function lowestRoomPrice()
    {
        return $this->rooms()
            ->where('is_active', true)
            ->min('price');
    }



    public function transformForApi()
    {

        $this->images->transform(fn($image) => getFileUrlForFrontend($image->image));


        $grouped = $this->facilities->groupBy('facility_id');
        $this->facilities = $grouped->map(function ($services, $facilityId) {
            $parent = $services->first()->facility;

            return [
                'name' => $parent->name ?? 'No Facility',
                'icon' => $parent->icon ?? null,
                'services' => $services->map(function ($service) {
                    return [
                        'type_name' => $service->type_name,
                        'icon' => $service->icon,
                    ];
                })->values(),
            ];
        })->values();

        // Package type → icon, type_name, is_refundable
        $this->package_type = $this->packageType ? [
            'icon' => $this->packageType->icon,
            'type_name' => $this->packageType->type_name,
            'is_refundable' => (bool) $this->packageType->is_refundable,
        ] : null;

        unset($this->packageType);

        // Lowest room price
        $this->lowest_price = $this->lowestRoomPrice();

        // Rooms → transform
        $this->rooms->transform(function ($room) {
            // Images
            $room->images->transform(fn($image) => getFileUrlForFrontend($image->image));

            // Services
            $room->services->transform(fn($service) => [
                'name' => $service->service->type_name ?? $service->type_name,
                'icon' => $service->service->icon ?? $service->icon,
            ]);

            // Rate details
            $room->rateDetails->transform(fn($rate) => [
                'id' => $rate->id,
                'room_id' => $rate->room_id,
                'title' => $rate->title,
                'is_active' => (bool) $rate->is_active,
            ]);

            return $room;
        });

        return $this;
    }
}
