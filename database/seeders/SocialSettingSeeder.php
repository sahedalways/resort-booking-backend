<?php

namespace Database\Seeders;

use App\Models\SocialInfoSettings;
use Illuminate\Database\Seeder;

class SocialSettingSeeder extends Seeder
{
  public function run(): void
  {
    SocialInfoSettings::create([
      'facebook'  => 'https://facebook.com/bookingXpart',
      'twitter'   => 'https://twitter.com/bookingXpart',
      'instagram' => 'https://instagram.com/bookingXpart',
      'linkedin'  => 'https://linkedin.com/in/bookingXpart',
      'youtube'   => 'https://youtube.com/bookingXpart',
    ]);
  }
}
