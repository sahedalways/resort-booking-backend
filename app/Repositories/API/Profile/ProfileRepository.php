<?php

namespace App\Repositories\API\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ProfileRepository
{

  public function updateAvatar(User $user, $avatarFile)
  {
    $profile = $user->profile;

    if (!$profile) {
      $profile = $user->profile()->create([]);
    }

    $filename = Str::uuid() . '.' . $avatarFile->getClientOriginalExtension();

    $img = Image::read($avatarFile->getRealPath());

    $directory = storage_path('app/public/image/avatar');

    if (!file_exists($directory)) {
      mkdir($directory, 0755, true);
    }


    if ($avatarFile) {
      Storage::disk('public')->delete($avatarFile);
    }


    $path = $directory . '/' . $filename;
    $img->save($path);



    $profile->avatar = 'image/avatar/' . $filename;
    $profile->save();

    return $profile;
  }


  /**
   * Update user's name in users table
   */
  public function updateUserName(User $user, array $data): User
  {
    $user->update([
      'f_name' => $data['f_name'] ?? $user->f_name,
      'l_name' => $data['l_name'] ?? $user->l_name,
    ]);

    return $user->fresh();
  }



  /**
   * Update user's profile table
   */
  public function updateProfile(User $user, array $data): User
  {
    // Remove f_name & l_name since those belong to users table
    $profileData = $data;
    unset($profileData['f_name'], $profileData['l_name']);

    $profile = $user->profile;
    if ($profile) {
      $profile->update($profileData);
    } else {
      $user->profile()->create($profileData);
    }

    return $user->fresh();
  }
}
