<?php

namespace App\Repositories;

use App\Models\PasswordReset;
use Illuminate\Support\Facades\DB;

class PasswordResetRepository
{
  public function updateOrCreateByEmail(string $email, string $otp): PasswordReset
  {
    return PasswordReset::updateOrCreate(
      ['email' => $email],
      ['otp' => $otp, 'created_at' => now()]
    );
  }

  public function updateOrCreateByPhone(string $phone, string $otp): PasswordReset
  {
    return PasswordReset::updateOrCreate(
      ['phone_no' => $phone],
      ['otp' => $otp, 'created_at' => now()]
    );
  }


  public function findByOtp(string $otp)
  {
    return PasswordReset::where('otp', $otp)->first(['email', 'phone_no', 'created_at']);
  }

  public function deleteByOtp(string $otp): void
  {
    PasswordReset::where('otp', $otp)->delete();
  }
}
