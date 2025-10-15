<?php

namespace App\Services\API\Profile;

use App\Models\User;
use App\Repositories\API\Profile\ProfileRepository;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
  protected ProfileRepository $repository;

  public function __construct(ProfileRepository $repository)
  {
    $this->repository = $repository;
  }



  public function getProfileOverview($user)
  {
    return $this->repository->getProfileOverview($user);
  }



  public function changeAvatar($user, $avatarFile)
  {
    return $this->repository->updateAvatar($user, $avatarFile);
  }



  public function updateProfile(User $user, array $data): User
  {

    $this->repository->updateUserName($user, $data);

    return $this->repository->updateProfile($user, $data);
  }



  public function changePassword(User $user, array $data): bool
  {
    if (!Hash::check($data['current_password'], $user->password)) {
      return false;
    }

    // Hash new password
    $newPassword = Hash::make($data['new_password']);

    // Update via repository
    return $this->repository->updatePassword($user, $newPassword);
  }
}
