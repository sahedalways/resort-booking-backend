<?php

namespace App\Services\API;

use App\Jobs\SendOtpEmailJob;
use App\Models\User;
use App\Repositories\API\EmailVerificationRepository;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EmailVerificationService
{
  protected EmailVerificationRepository $repository;

  public function __construct(EmailVerificationRepository $repository)
  {
    $this->repository = $repository;
  }




  public function sendOtp(string $email, $name): bool
  {
    $otp = rand(100000, 999999);

    $this->repository->updateOrInsert($email, $otp);

    try {
      // Dispatch email job to queue
      dispatch(new SendOtpEmailJob($email, $name, $otp))->onConnection('sync')->onQueue('urgent');

      return true;
    } catch (\Exception $e) {
      \Log::error('OTP queue dispatch failed: ' . $e->getMessage());
      return false;
    }
  }
  public function verifyOtp(string $email, string $otp): User
  {
    $record = $this->repository->findByEmailAndOtp($email, $otp);

    if (!$record) {
      throw new \Exception('Invalid OTP!');
    }

    if (Carbon::parse($record->created_at)->diffInMinutes(now()) > 2) {
      throw new \Exception('OTP expired!');
    }

    // Mark user as verified
    $user = User::where('email', $email)->firstOrFail();
    $user->email_verified_at = now();
    $user->save();

    // Delete OTP after use
    $this->repository->deleteByEmail($email);

    return $user;
  }
}
