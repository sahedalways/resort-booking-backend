<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResortPackageType;

class ResortPackageTypesSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            ['type_name' => 'Standard', 'icon' => 'fas fa-bed', 'is_refundable' => true],
            ['type_name' => 'Non Refundable', 'icon' => 'fas fa-ban', 'is_refundable' => false],
            ['type_name' => 'Deluxe', 'icon' => 'fas fa-hotel', 'is_refundable' => true],
            ['type_name' => 'Suite', 'icon' => 'fas fa-gem', 'is_refundable' => true],
            ['type_name' => 'Family Package', 'icon' => 'fas fa-users', 'is_refundable' => true],
            ['type_name' => 'Honeymoon Package', 'icon' => 'fas fa-heart', 'is_refundable' => true],
        ];

        foreach ($packages as $package) {
            ResortPackageType::create($package);
        }
    }
}
