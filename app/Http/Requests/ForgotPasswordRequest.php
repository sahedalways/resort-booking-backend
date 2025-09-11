<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'nullable|string|email|max:255',
            'phone_no' => 'nullable|string|max:15',
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Please provide a valid email address.',
        ];
    }
}
