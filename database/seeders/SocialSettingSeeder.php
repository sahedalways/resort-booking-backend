<?php

namespace Database\Seeders;

use App\Models\SocialInfoSettings;
use Illuminate\Database\Seeder;

class SocialSettingSeeder extends Seeder
{
  public function run(): void
  {
    SocialInfoSettings::create([
      'facebook'  => 'https://facebook.com/BookingXpert',
      'twitter'   => 'https://twitter.com/BookingXpert',
      'instagram' => 'https://instagram.com/BookingXpert',
      'linkedin'  => 'https://linkedin.com/in/BookingXpert',
      'youtube'   => 'https://youtube.com/BookingXpert',
    ]);
  }
}
