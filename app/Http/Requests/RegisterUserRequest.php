<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'f_name'     => 'required|string|max:255',
            'l_name'     => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email',
            'phone_no'   => 'required|string|max:20|unique:users,phone_no',
            'password'   => 'required|string|min:8|confirmed',
        ];
    }
}
