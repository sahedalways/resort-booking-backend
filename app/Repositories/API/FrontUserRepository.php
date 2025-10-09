<?php

namespace App\Repositories\API;

use App\Models\User;

class FrontUserRepository
{
  public function findByEmail($email): ?User
  {
    return User::where('email', $email)->where('user_type', 'user')->first();
  }


  public function delete(User $user): bool
  {
    return $user->delete();
  }


  public function getAllUsers()
  {
    return User::where('user_type', 'user')->latest()->get();
  }

  public function updatePasswordByAPI(string $identifier, string $hashedPassword): bool
  {
    return User::where('email', $identifier)
      ->update(['password' => $hashedPassword]) > 0;
  }
}
