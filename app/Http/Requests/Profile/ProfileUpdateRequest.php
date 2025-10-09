<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
  public function authorize(): bool
  {
    return auth()->check();
  }

  public function rules(): array
  {
    return [
      'f_name' => 'required|string|max:50',
      'l_name' => 'required|string|max:50',
      'gender' => 'nullable|in:Male,Female,Other',
      'present_address' => 'nullable|string|max:100',
      'permanent_address' => 'nullable|string|max:100',
      'marital_status' => 'nullable|in:Single,Married,Divorced,Widowed',
      'date_of_birth' => 'nullable|date',
      'national_id' => 'nullable|numeric|digits_between:5,17',
      'nationality' => 'nullable|in:Bangladeshi',
      'religion' => 'nullable|in:Islam,Hinduism,Christianity,Buddhism,Other',
    ];
  }
}
