<?php

namespace App\Services\API;

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



  public function handle(?string $email, ?string $phone): array
  {
    $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

    if ($email) {
      $user = $this->authRepository->findUserByEmail($email, 'user');
      if (!$user) {
        throw new \Exception('User with this email not found!');
      }

      // Save OTP
      $this->passwordResetRepository->updateOrCreateByEmail($email, $otp);

      // Send email
      Mail::send('mail.forgotPassword', [
        'data' => [
          'otp'   => $otp,
          'email' => $email,
          'title' => "Password Reset",
          'body'  => "Use the OTP below to reset your password.",
        ]
      ], function ($message) use ($email) {
        $message->to($email)->subject('Password Reset');
      });

      return ['email' => $email];
    }

    if ($phone) {
      $user = $this->authRepository->findUserByPhone($phone);
      if (!$user) {
        throw new \Exception('User with this phone number not found!');
      }

      // Save OTP
      $this->passwordResetRepository->updateOrCreateByPhone($phone, $otp);

      // Send SMS (dummy function)
      $this->sendOtpToPhone($phone, $otp);

      return ['phone_no' => $phone];
    }

    throw new \Exception('Email address or Phone number is required.');
  }

  protected function sendOtpToPhone(string $phone, string $otp): void
  {
    $sid   = env('TWILIO_SID');
    $token = env('TWILIO_AUTH_TOKEN');
    $from  = env('TWILIO_PHONE_NO');

    $messageBody = "Your OTP for password reset is: $otp. Please use this to complete the process.";

    try {
      $client = new Client($sid, $token);
      $client->messages->create(
        $phone,
        [
          'from' => $from,
          'body' => $messageBody,
        ]
      );
    } catch (\Exception $e) {
      throw new \Exception("Failed to send message: " . $e->getMessage());
    }
  }
}
