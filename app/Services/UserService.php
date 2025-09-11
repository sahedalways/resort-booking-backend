<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;


class UserService
{
  protected $userRepo;

  public function __construct(UserRepository $userRepo)
  {
    $this->userRepo = $userRepo;
  }



  public function register(array $data): User
  {

    return $this->userRepo->create($data);
  }



  public function getAllUsers()
  {
    return $this->userRepo->getAllUsers();
  }



  public function getUser($id): ?User
  {
    return $this->userRepo->find($id);
  }



  public function updateUser(User $user, array $data): User
  {

    return $this->userRepo->update($user, $data);
  }



  public function deleteUser($id): bool
  {
    $user = $this->getUser($id);

    if (!$user) {
      return false;
    }

    return $this->userRepo->delete($user);
  }
}
