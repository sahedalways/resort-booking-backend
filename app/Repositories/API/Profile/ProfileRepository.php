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
}
