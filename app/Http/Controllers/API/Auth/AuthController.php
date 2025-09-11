<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\MatchPincodeRequest;
use App\Http\Requests\RegisterEmailConfirmOTPRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Services\EmailVerificationService;
use App\Services\ForgotPasswordService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




class AuthController extends BaseController
{

    protected UserService $userService;
    protected AuthService $authService;
    protected ForgotPasswordService $forgotPasswordService;
    protected EmailVerificationService $emailVerificationService;

    public function __construct(UserService $userService, ForgotPasswordService $ForgotPasswordService, AuthService $authService, EmailVerificationService $emailVerificationService)
    {
        $this->userService = $userService;
        $this->forgotPasswordService = $ForgotPasswordService;
        $this->authService = $authService;
        $this->emailVerificationService = $emailVerificationService;
    }

    public function register(RegisterUserRequest $request)
    {
        $request->validated();

        // ✅ Call Service Layer
        $user = $this->authService->registerUserByAPI($request->only([
            'f_name',
            'l_name',
            'email',
            'phone_no',
            'password'
        ]));

        $this->emailVerificationService->sendOtp($user->email);

        return $this->sendResponse([
            'email'     => $user->email,
        ], 'User registered successfully.');
    }




    public function verifyEmailConfirmOTP(RegisterEmailConfirmOTPRequest $request)
    {
        $request->validated();


        $user =  $this->emailVerificationService->verifyOtp($request->email, $request->otp);

        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return $this->sendResponse([
            'token'     => $token,
            'id'        => $user->id,
            'f_name'    => $user->f_name,
            'l_name'    => $user->l_name,
            'email'     => $user->email,
            'phone_no'  => $user->phone_no,
            'user_type' => $user->user_type,
        ], 'Email verified successfully.');
    }


    // for login function
    public function login(LoginRequest $request)
    {
        $request->validated();


        try {
            $user = $this->authService->loginByAPI(
                $request->input('email'),
                $request->input('password')
            );



            if (!$user) {
                return $this->sendError('Email or Password is incorrect!', ['error' => 'Unauthorized']);
            }

            if (is_null($user->email_verified_at)) {
                $this->emailVerificationService->sendOtp($user->email);

                return $this->sendResponse(
                    ['email' => $user->email],
                    'Email not verified. OTP sent to your email.'
                );
            }



            $newToken = $user->createToken('Personal Access Token');


            return $this->sendResponse([
                'token'     => $newToken,
                'id'        => $user->id,
                'f_name'    => $user->f_name,
                'l_name'    => $user->l_name,
                'email'     => $user->email,
                'phone_no'  => $user->phone_no,
                'user_type' => $user->user_type,
            ], 'User login successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Unauthorized', ['error' => $e->getMessage()]);
        }
    }



    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $result = $this->forgotPasswordService->handle(
                $request->input('email'),
                $request->input('phone_no')
            );

            return $this->sendResponse($result, 'OTP sent successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Failed to send OTP', ['error' => $e->getMessage()]);
        }
    }


    public function matchPincode(MatchPincodeRequest $request)
    {
        try {
            $result = $this->authService->matchPincode($request->otp);


            return $this->sendResponse($result, 'Your OTP is correct!');
        } catch (\Exception $e) {
            return $this->sendError('OTP does not match.', ['error' => $e->getMessage()]);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $success = $this->authService->updatePasswordByAPI(
                $request->identifier,
                $request->password
            );

            if ($success) {
                return $this->sendResponse($success, 'Password has been changed successfully!');
            }

            return $this->sendError('Password change failed. User not found!');
        } catch (\Exception $e) {
            return $this->sendError('Password change failed.', ['error' => $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'Successfully logged out.']);
    }
}
