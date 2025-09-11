<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository;
use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{

  protected AuthRepository $authRepo;
  protected PasswordResetRepository $passwordResetRepo;
  protected UserRepository $userRepo;


  public function __construct(AuthRepository $authRepo, PasswordResetRepository $passwordResetRepo, UserRepository $userRepo)
  {
    $this->authRepo = $authRepo;
    $this->passwordResetRepo = $passwordResetRepo;
    $this->userRepo = $userRepo;
  }


  /**
   * Admin login logic
   *
   * @param string $email
   * @param string $password
   * @return bool
   */
  public function loginAdmin(string $email, string $password): bool
  {
    return Auth::attempt([
      'email'     => $email,
      'password'  => $password,
      'user_type' => 'admin',
    ]);
  }

  public function registerUserByAPI(array $data): User
  {
    $data['password'] = Hash::make($data['password']);
    return $this->authRepo->createByAPI($data);
  }



  public function loginByAPI(string $email, string $password): User
  {
    $user = $this->authRepo->findUserByEmail($email);

    if (!$user || !Auth::attempt(['email' => $email, 'password' => $password])) {
      throw new \Exception('Email or Password is incorrect!');
    }

    $user = Auth::user();
    return $user;
  }


  public function matchPincode(string $otp): array
  {
    $record = $this->passwordResetRepo->findByOtp($otp);

    if (!$record) {
      throw new \Exception('OTP does not match!');
    }

    $createdAt = Carbon::parse($record->created_at);
    if ($createdAt->diffInMinutes(Carbon::now()) > 2) {
      throw new \Exception('OTP expired! Please request a new one.');
    }

    $identifier = $record->email ?? $record->phone_no;

    // ✅ Delete OTP once used
    $this->passwordResetRepo->deleteByOtp($otp);

    return ['identifier' => $identifier];
  }

  public function updatePasswordByAPI(string $identifier, string $password): bool
  {
    $hashedPassword = Hash::make($password);

    return $this->userRepo->updatePasswordByAPI($identifier, $hashedPassword);
  }

  public function logout($user): void
  {
    $user->currentAccessToken()->delete();
  }
}
