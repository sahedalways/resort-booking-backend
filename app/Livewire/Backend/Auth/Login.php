<?php

namespace App\Livewire\Backend\Auth;

use App\Repositories\AuthRepository;
use App\Traits\ToastTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    use ToastTrait;

    public $email, $password, $success = false;


    protected $rules = [
        'email'    => 'required|email',
        'password' => 'required',
    ];



    //Render Page
    public function render()
    {
        return view('livewire.backend.auth.login')->extends('components.layouts.login_layout')->section('content');
    }
    //Process Login
    public function login(AuthRepository $authRepository)
    {
        $this->validate();
        if ($authRepository->loginAdmin($this->email, $this->password)) {
            return redirect()->intended('admin/dashboard');
        }

        $this->toast('Invalid Email or Password', 'error');
    }


    //Initialize Variables
    public function mount()
    {
        if (app('authUser')) {
            if (app('authUser')->user_type == 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }
    }
}
