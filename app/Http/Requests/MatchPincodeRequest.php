<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatchPincodeRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'otp' => ['required', 'digits:6']
    ];
  }
}
