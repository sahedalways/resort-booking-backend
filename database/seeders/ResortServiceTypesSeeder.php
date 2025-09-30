<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResortServiceType;

class ResortServiceTypesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['type_name' => 'Free Wifi', 'icon' => 'fas fa-wifi'],
            ['type_name' => 'Room service', 'icon' => 'fas fa-concierge-bell'],
            ['type_name' => 'TV', 'icon' => 'fas fa-tv'],
            ['type_name' => 'Wardrobe/Closet', 'icon' => 'fas fa-wardrobe'],
            ['type_name' => 'Slippers', 'icon' => 'fas fa-person-booth'],
            ['type_name' => 'Toiletries', 'icon' => 'fas fa-toilet'],
            ['type_name' => 'Shower', 'icon' => 'fas fa-shower'],
            ['type_name' => 'Event facilities', 'icon' => 'fas fa-calendar-check'],
            ['type_name' => 'Conference Hall', 'icon' => 'fas fa-users'],
            ['type_name' => 'Air conditioning', 'icon' => 'fas fa-fan'],
            ['type_name' => 'Reception desk', 'icon' => 'fas fa-receipt'],
            ['type_name' => '24-hour reception', 'icon' => 'fas fa-clock'],
            ['type_name' => 'Coffee/tea for guests', 'icon' => 'fas fa-mug-hot'],
            ['type_name' => 'Breakfast', 'icon' => 'fas fa-bacon'],
            ['type_name' => 'Restaurant', 'icon' => 'fas fa-utensils'],
            ['type_name' => 'Breakfast/lunch to go', 'icon' => 'fas fa-box'],
            ['type_name' => 'Bottled water', 'icon' => 'fas fa-water'],
            ['type_name' => 'Pets Not Allowed', 'icon' => 'fas fa-ban'],
            ['type_name' => 'English', 'icon' => 'fas fa-language'],
            ['type_name' => 'Temperature control for guests', 'icon' => 'fas fa-thermometer-half'],
            ['type_name' => 'Swimming pool', 'icon' => 'fas fa-swimming-pool'],
            ['type_name' => 'Welcome drinks', 'icon' => 'fas fa-glass-cheers'],
            ['type_name' => 'Travel desk', 'icon' => 'fas fa-concierge-bell'],
            ['type_name' => 'Non-smoking rooms', 'icon' => 'fas fa-smoking-ban'],
            ['type_name' => 'Bathtub', 'icon' => 'fas fa-bath']
        ];

        foreach ($services as $service) {
            ResortServiceType::create($service);
        }
    }
}
