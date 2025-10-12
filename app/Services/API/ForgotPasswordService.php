<?php

namespace App\Services\API;

use App\Jobs\SendPasswordResetOtpJob;
use App\Repositories\API\FrontAuthRepository;
use App\Repositories\API\FrontUserRepository;
use App\Repositories\API\PasswordResetRepository;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class ForgotPasswordService
{
  protected FrontUserRepository $userRepository;
  protected PasswordResetRepository $passwordResetRepository;
  protected FrontAuthRepository $authRepository;

  public function __construct(FrontUserRepository $userRepository, PasswordResetRepository $passwordResetRepository, FrontAuthRepository $authRepository)
  {
    $this->userRepository = $userRepository;
    $this->passwordResetRepository = $passwordResetRepository;
    $this->authRepository = $authRepository;
  }



  public function handle(?string $email): array
  {
    if (!$email) {
      throw new \Exception('Email address is required.');
    }

    $user = $this->authRepository->findUserByEmail($email, 'user');
    if (!$user) {
      throw new \Exception('User with this email not found!');
    }

    // Generate OTP
    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

    // Save OTP
    $this->passwordResetRepository->updateOrCreateByEmail($email, $otp);

    // Dispatch email job
    // dispatch(new SendPasswordResetOtpJob($email, $otp));

    return ['email' => $email];
  }
}
