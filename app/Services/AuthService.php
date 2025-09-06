<?php

namespace App\Services;

use App\Repositories\AuthRepository;

class AuthService
{
  protected $authRepository;

  public function __construct(AuthRepository $authRepository)
  {
    $this->authRepository = $authRepository;
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
    return $this->authRepository->loginAdmin($email, $password);
  }
}
