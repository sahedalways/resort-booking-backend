<?php

namespace Database\Seeders;

use App\Models\ResortRoomFacilityOption;
use App\Models\ResortServiceType;
use Illuminate\Database\Seeder;
use App\Models\ResortRoomFacility;


class ResortRoomFacilitiesSeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            'Internet' => [
                'options' => ['Free Wi-Fi'],
                'icon' => 'fas fa-wifi'
            ],
            'Rooms' => [
                'options' => ['Room service', 'TV', 'Wardrobe/Closet', 'Slippers', 'Toiletries', 'Shower'],
                'icon' => 'fas fa-bed'
            ],
            'Business' => [
                'options' => ['Event facilities', 'Conference Hall'],
                'icon' => 'fas fa-briefcase'
            ],
            'Services' => [
                'options' => ['Air conditioning', 'Reception desk', '24-hour reception'],
                'icon' => 'fas fa-user'
            ],
            'Meals' => [
                'options' => ['Coffee/tea for guests', 'Breakfast', 'Restaurant', 'Breakfast/lunch to go', 'Bottled water'],
                'icon' => 'fas fa-utensils'
            ],
            'Pets' => [
                'options' => ['Pets Not Allowed'],
                'icon' => 'fas fa-paw'
            ],
            'Languages Spoken' => [
                'options' => ['English'],
                'icon' => 'fas fa-language'
            ],
            'Health and Safety Measures' => [
                'options' => ['Temperature control for guests'],
                'icon' => 'fas fa-thermometer-half'
            ],
        ];

        foreach ($facilities as $facilityName => $data) {
            $facility = ResortRoomFacility::create([
                'name' => $facilityName,
                'icon' => $data['icon']
            ]);

            foreach ($data['options'] as $optionName) {
                $service = ResortServiceType::where('type_name', $optionName)->first();

                if ($service) {
                    ResortRoomFacilityOption::create([
                        'facility_id' => $facility->id,
                        'service_id' => $service->id
                    ]);
                } else {
                    echo "Service not found: " . $optionName . "\n";
                }
            }
        }
    }
}
