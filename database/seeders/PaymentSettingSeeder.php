<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentSetting;

class PaymentSettingSeeder extends Seeder
{
  public function run(): void
  {
    // bKash
    PaymentSetting::create([
      'gateway'   => 'bkash',
      'app_key'   => 'bkash_test_app_key',
      'app_secret' => 'bkash_test_app_secret',
      'username'  => 'bkash_test_username',
      'password'  => 'bkash_test_password',
      'base_url'  => 'https://sandbox.bkash.com',
      'is_active' => true,
    ]);
  }
}
