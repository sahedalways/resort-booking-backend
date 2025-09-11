<?php

use App\Http\Controllers\API\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['cors'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        // for authentication routes
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('verify-email-otp', 'verifyEmailOtp');

        // for for forger password routes
        Route::post('forgot-password', 'forgotPassword');
        Route::post('match-otp', 'matchPincode');
        Route::post('change-password', 'changePassword');
    });
});



// For inquiries regarding mobile or web application development, feel free to reach out!

// 📧 Email: ssahed65@gmail.com
// 📱 WhatsApp: +8801616516753
// My name is Sk Sahed Ahmed, and I look forward to collaborating with you!