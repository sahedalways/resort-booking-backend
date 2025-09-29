<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomBedType;

class RoomBedTypesSeeder extends Seeder
{
    public function run(): void
    {
        $bedTypes = [
            ['type_name' => 'DOUBLE x 1'],
            ['type_name' => 'DOUBLE x 2'],
            ['type_name' => 'SINGLE x 1'],
            ['type_name' => 'SINGLE x 2'],
            ['type_name' => 'QUEEN x 1'],
            ['type_name' => 'KING x 1'],
            ['type_name' => 'TWIN x 2'],
        ];

        foreach ($bedTypes as $bedType) {
            RoomBedType::create($bedType);
        }
    }
}
