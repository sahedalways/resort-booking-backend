<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomViewType;

class RoomViewTypesSeeder extends Seeder
{
    public function run(): void
    {
        $viewTypes = [
            ['type_name' => 'Hill View'],
            ['type_name' => 'Sea View'],
            ['type_name' => 'Garden View'],
            ['type_name' => 'City View'],
            ['type_name' => 'Pool View'],
        ];

        foreach ($viewTypes as $viewType) {
            RoomViewType::create($viewType);
        }
    }
}
