<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class AvatarRequest extends FormRequest
{
  public function authorize()
  {
    // Only authenticated users can update avatar
    return auth()->check();
  }

  public function rules()
  {
    return [
      'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];
  }

  public function messages()
  {
    return [
      'avatar.required' => 'Avatar file is required.',
      'avatar.image'    => 'File must be an image.',
      'avatar.mimes'    => 'Only jpeg, png, jpg, gif allowed.',
      'avatar.max'      => 'Maximum file size is 2MB.',
    ];
  }
}
