<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
  public function run(): void
  {
    SiteSetting::create([
      'site_title'        => 'Resort & Hotel Booking',
      'logo'              => 'png',
      'favicon'           => 'ico',
      'hero_image'        => 'jpg',
      'site_phone_number' => '+880171200000',
      'site_email'             => 'info@example.com',
      'copyright_text'    => '© ' . date('Y') . ' Resort Booking. All rights reserved.',
    ]);
  }
}