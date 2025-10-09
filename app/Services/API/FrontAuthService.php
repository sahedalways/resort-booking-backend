<?php

namespace App\Services\API;

use App\Models\User;
use App\Repositories\API\FrontAuthRepository;
use App\Repositories\API\FrontUserRepository;
use App\Repositories\API\PasswordResetRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontAuthService
{

  protected FrontAuthRepository $authRepo;
  protected PasswordResetRepository $passwordResetRepo;
  protected FrontUserRepository $userRepo;


  public function __construct(FrontAuthRepository $authRepo, PasswordResetRepository $passwordResetRepo, FrontUserRepository $userRepo)
  {
    $this->authRepo = $authRepo;
    $this->passwordResetRepo = $passwordResetRepo;
    $this->userRepo = $userRepo;
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

    $identifier = $record->email;

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
