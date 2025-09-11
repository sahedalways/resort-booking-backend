<?php

namespace App\Repositories;

use App\Models\User;
use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthRepository
{


  protected $authService;

  public function __construct(AuthService $authService)
  {
    $this->authService = $authService;
  }

  /**
   * Attempt login for admin
   *
   * @param string $email
   * @param string $password
   * @return bool
   */
  public function loginAdmin(string $email, string $password): bool
  {
    return $this->authService->loginAdmin($email, $password);
  }



  public function createByAPI(array $data): User
  {
    return User::create($data);
  }

  public function findUserByEmail(string $email, string $type = 'user'): ?User
  {
    return User::where('email', $email)
      ->where('user_type', $type)
      ->first();
  }


  public function findUserByPhone(string $phone): ?User
  {
    return User::where('phone_no', $phone)->first();
  }


  public function updatePasswordByAPI(string $identifier, string $hashedPassword): bool
  {
    return User::where('email', $identifier)
      ->orWhere('phone_no', $identifier)
      ->update(['password' => $hashedPassword]) > 0;
  }



  public function updateOrInsert(string $email, string $otp): void
  {
    DB::table('email_verifications')->updateOrInsert(
      ['email' => $email],
      [
        'otp' => $otp,
        'created_at' => Carbon::now(),
      ]
    );
  }

  public function findByEmailAndOtp(string $email, string $otp)
  {
    return DB::table('email_verifications')
      ->where('email', $email)
      ->where('otp', $otp)
      ->first();
  }

  public function deleteByEmail(string $email): void
  {
    DB::table('email_verifications')->where('email', $email)->delete();
  }
}
