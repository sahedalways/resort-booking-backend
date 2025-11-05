<?php

namespace App\Repositories\API;

use App\Models\PasswordResetToken;

class PasswordResetRepository
{
  public function updateOrCreateByEmail(string $email, string $otp): PasswordResetToken
  {
    return PasswordResetToken::updateOrCreate(
      ['email' => $email],
      // ['token' => $otp, 'created_at' => now()]
      ['token' => $otp, 'created_at' => now()]
    );
  }


  public function findByOtp(string $otp)
  {
    return PasswordResetToken::where('token', $otp)->first(['email', 'created_at']);
  }

  public function deleteByOtp(string $otp): void
  {
    PasswordResetToken::where('token', $otp)->delete();
  }
}
