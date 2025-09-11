<?php

namespace App\Services\API;


use App\Models\User;
use App\Repositories\API\FrontUserRepository;

class FrontUserService
{
  protected $userRepo;

  public function __construct(FrontUserRepository $userRepo)
  {
    $this->userRepo = $userRepo;
  }

  public function findByEmail($email): ?User
  {
    return $this->userRepo->findByEmail($email);
  }

  public function getAllUsers()
  {
    return $this->userRepo->getAllUsers();
  }
}
