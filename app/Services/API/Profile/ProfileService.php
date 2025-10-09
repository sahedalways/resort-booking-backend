<?php

namespace App\Services\API\Profile;


use App\Repositories\API\Profile\ProfileRepository;


class ProfileService
{
  protected ProfileRepository $repository;

  public function __construct(ProfileRepository $repository)
  {
    $this->repository = $repository;
  }



  public function changeAvatar($user, $avatarFile)
  {
    return $this->repository->updateAvatar($user, $avatarFile);
  }
}
