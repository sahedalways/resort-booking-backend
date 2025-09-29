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
            ['type_name' => 'Bathtub', 'icon' => 'fas fa-bath'],
            ['type_name' => 'Welcome drinks', 'icon' => 'fas fa-glass-cheers'],
            ['type_name' => 'Swimming pool', 'icon' => 'fas fa-swimming-pool'],
            ['type_name' => 'Travel desk', 'icon' => 'fas fa-concierge-bell'],
            ['type_name' => 'Non-smoking rooms', 'icon' => 'fas fa-smoking-ban'],
            ['type_name' => 'Room service', 'icon' => 'fas fa-concierge-bell'],
            ['type_name' => 'Slippers', 'icon' => 'fas fa-person-booth'],
            ['type_name' => 'Toiletries', 'icon' => 'fas fa-toilet'],
            ['type_name' => 'Shower', 'icon' => 'fas fa-shower']
        ];

        foreach ($services as $service) {
            ResortServiceType::create($service);
        }
    }
}
