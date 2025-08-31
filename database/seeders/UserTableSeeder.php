<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {

    // for creating admin user
    User::create(attributes: [
      'f_name' => 'Mr',
      'l_name' => 'Admin',
      'email' => 'admin@admin.com',
      'password' => 12345678,
      'user_type' => 'admin',
    ]);


    // for creating regular user
    User::create([
      'f_name' => 'Mr',
      'l_name' => 'User',
      'email' => 'user@user.com',
      'password' => 12345678,
      'user_type' => 'user',
    ]);
  }
}