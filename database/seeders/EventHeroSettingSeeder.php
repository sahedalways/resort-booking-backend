<?php

namespace Database\Seeders;

use App\Models\EventHero;
use Illuminate\Database\Seeder;

class EventHeroSettingSeeder extends Seeder
{
  public function run(): void
  {
    EventHero::create([
      'title'        => 'Choose the Best Event Planner',
      'sub_title'        => 'BookingXpert Event Planner your premier choice for weddings, parties & corporate events.',
      'hero_image'        => 'webp',
      'phone_number' => '+8801877556633',
    ]);
  }
}
