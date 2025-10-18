<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Allow all users to submit
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|max:255',
            'date_of_function' => 'required|string|max:255',
            'gathering_size' => 'required|integer',
            'message' => 'nullable|string|max:1000',
        ];
    }
}
