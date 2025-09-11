<?php

namespace App\Services;


use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;


class AuthService
{

  protected AuthRepository $authRepo;


  public function __construct(AuthRepository $authRepo)
  {
    $this->authRepo = $authRepo;
  }


  /**
   * Admin login logic
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
