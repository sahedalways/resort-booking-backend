<?php

namespace App\Repositories\API;

use App\Models\EmailVerification;
use Carbon\Carbon;

class EmailVerificationRepository
{
  public function updateOrInsert(string $email, string $otp): void
  {
    $verification = EmailVerification::firstOrNew(['email' => $email]);

    $verification->otp = $otp;
    $verification->created_at = Carbon::now();
    $verification->save();
  }


  public function findByEmailAndOtp(string $email, string $otp): ?EmailVerification
  {
    return EmailVerification::where('email', $email)
      ->where('otp', $otp)
      ->first();
  }


  public function deleteByEmail(string $email): void
  {
    EmailVerification::where('email', $email)->delete();
  }
}
