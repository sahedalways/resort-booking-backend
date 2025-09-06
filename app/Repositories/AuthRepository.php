<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class AuthRepository
{
  /**
   * Attempt login for admin
   *
   * @param string $email
   * @param string $password
   * @return bool
   */
  public function loginAdmin(string $email, string $password): bool
  {
    return Auth::attempt([
      'email'     => $email,
      'password'  => $password,
      'user_type' => 'admin',
    ]);
  }
}
