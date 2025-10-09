<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\FooterController;
use App\Http\Controllers\API\HeaderController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ResortController;
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
        Route::post('verify-email-otp', 'verifyEmailConfirmOTP');
        Route::post('resend-otp', 'resendOtp');

        // for for forger password routes
        Route::post('forgot-password', 'forgotPassword');
        Route::post('forgot-password/match-otp', 'matchPincode');
        Route::post('change-password', 'changePassword');
    });


    // get home data api
    Route::controller(HomeController::class)->group(function () {
        Route::get('home-data', 'getHomeData');
    });



    // get header data api
    Route::controller(HeaderController::class)->group(function () {
        Route::get('header-data', 'getHeaderData');
    });


    // get footer data api
    Route::controller(FooterController::class)->group(function () {
        Route::get('footer-data', 'getFooterData');
    });



    // resort data apis
    Route::controller(ResortController::class)->group(function () {
        Route::get('resort-data', 'getResortData');
        Route::get('single-resort-data/{id}', 'getSingleResortData');
    });



    // get event data apis
    Route::controller(EventController::class)->group(function () {
        Route::get('event-data', 'getEventData');
        Route::get('single-event-data/{id}', 'getSingleEventData');
    });


    Route::middleware(['auth:sanctum'])->group(function () {
        // for logout
        Route::post('/logout', [AuthController::class, 'logout']);


        Route::prefix('profile')->group(function () {
            // change avatar route
            Route::post('change-avatar', [ProfileController::class, 'changeAvatar']);


            // change profile data route
            Route::post('/update', [ProfileController::class, 'profileDataUpdate']);
        });



        // booking related routes below
        Route::prefix('booking')->group(function () {
            Route::controller(BookingController::class)->group(function () {
                Route::get('history', 'getBookingHistory');
            });
        });
    });
});



// For inquiries regarding mobile or web application development, feel free to reach out!

// 📧 Email: ssahed65@gmail.com
// 📱 WhatsApp: +8801616516753
// My name is Sk Sahed Ahmed, and I look forward to collaborating with you!