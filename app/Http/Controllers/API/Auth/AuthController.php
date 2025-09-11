<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\MatchPincodeRequest;
use App\Http\Requests\RegisterEmailConfirmOTPRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\API\EmailVerificationService;
use App\Services\API\ForgotPasswordService;
use App\Services\API\FrontAuthService;
use Illuminate\Http\Request;



class AuthController extends BaseController
{

    public function register(RegisterUserRequest $request)
    {
        $request->validated();
    }
}
