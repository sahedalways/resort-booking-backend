<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResendOtpRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   */
  public function rules(): array
  {
    return [
      'email' => 'required|email|exists:users,email',
    ];
  }

  /**
   * Custom messages for validation errors.
   */
  public function messages(): array
  {
    return [
      'email.required' => 'Email is required.',
      'email.email' => 'Please provide a valid email address.',
      'email.exists' => 'This email is not registered.',
    ];
  }
}
