<?php

namespace Database\Seeders;

use App\Models\ContactInfoSettings;
use Illuminate\Database\Seeder;

class ContactInfoSettingSeeder extends Seeder
{
  public function run(): void
  {
    ContactInfoSettings::create([
      'email' => 'info@bookingxpart.com',
      'phone' => '+8801877556633',
      'dhaka_office_address' => '6th Floor, House 168, Block B, Sayednagar Gulsan, Dhaka 1212, Bangladesh',
      'gazipur_office_address' => '6th Floor, House 168, Block B, Sayednagar Gulsan, Dhaka 1212, Bangladesh',
    ]);
  }
}
