<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $email;
    protected string $otp;

    public function __construct(string $email, string $otp)
    {
        $this->email = $email;
        $this->otp = $otp;
    }

    public function handle(): void
    {
        Mail::send('mail.forgotPassword', [
            'data' => [
                'otp'   => $this->otp,
                'email' => $this->email,
                'title' => "Password Reset",
                'body'  => "Use the OTP below to reset your password.",
            ]
        ], function ($message) {
            $message->to($this->email)->subject('Password Reset');
        });
    }
}
