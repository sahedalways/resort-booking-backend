<?php

use App\Livewire\Backend\Auth\Login;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// login route
Route::get('/', [Login::class, '__invoke'])->name('login');


// imported external routes below
require __DIR__ . '/admin.php';


Route::get('/clear', function () {
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    return 'Routes cache has been cleared';
});

Route::get('/send-test-mail', function () {
    Mail::raw('This is a test email from Laravel.', function ($message) {
        $message->to('ssahed65@gmail.com')
            ->subject('Laravel Test Email');
    });

    return 'Test email sent to ssahed65@gmail.com';
});
