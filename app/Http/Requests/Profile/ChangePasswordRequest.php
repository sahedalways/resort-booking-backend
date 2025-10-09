<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
  public function authorize()
  {
    return auth()->check();
  }

  public function rules()
  {
    return [
      'current_password' => ['required', 'string', 'min:8'],
      'new_password'     => ['required', 'string', 'min:8', 'max:20'],
      'c_password'       => ['required', 'same:new_password'],
    ];
  }
}
