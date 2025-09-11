<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterEmailConfirmOTPRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:email_verifications,email'],
            'otp'   => ['required', 'digits:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required for verification.',
            'email.email'    => 'Please provide a valid email address.',
            'email.exists'   => 'No verification request found for this email.',
            'otp.required'   => 'Please enter the OTP sent to your email.',
            'otp.digits'     => 'OTP must be exactly 6 digits.',
        ];
    }
}
