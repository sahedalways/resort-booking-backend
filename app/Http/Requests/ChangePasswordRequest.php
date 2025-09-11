<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'password'    => ['required', 'string', 'min:8'],
      'c_password'  => ['required', 'same:password'],
      'identifier'  => ['required'],
    ];
  }
}
