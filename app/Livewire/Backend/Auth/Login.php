<?php

namespace App\Livewire\Backend\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email, $password, $success = false;
    //Render Page
    public function render()
    {
        return view('livewire.backend.auth.login')->extends('components.layouts.login_layout')->section('content');
    }
    //Process Login
    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password, 'user_type' => 'admin'])) {
            /* user type admin and login is successful */
            return redirect('admin/dashboard');
        }
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password, 'user_type' => 'user'])) {
            /* user type admin and login is successful */
            return redirect('/user/dashboard');
        } else {
            /* if the credentials are incorrect */
            return $this->addError('login_error', 'Invalid Email/Password');
        }
    }
    //Initialize Variables
    public function mount()
    {
        if (Auth::user()) {
            if (Auth::user()->user_type == 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }
    }
}