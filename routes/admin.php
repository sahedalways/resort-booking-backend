<?php

use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ResortController;
use App\Http\Controllers\Admin\RoomController;
use App\Livewire\Backend\BookingInfo\BookingList;
use App\Livewire\Backend\ContactInfo;
use App\Livewire\Backend\Coupons\ManageCoupons;
use App\Livewire\Backend\Dashboard;
use App\Livewire\Backend\ManageContent\FeaturesImages;
use App\Livewire\Backend\ManageEvent\EventHero;
use App\Livewire\Backend\ManageEvent\EventServices;
use App\Livewire\Backend\ManageResort\ManageFacilities;
use App\Livewire\Backend\ManageResort\ManageResort;
use App\Livewire\Backend\ManageResort\ManageResortFacilities;
use App\Livewire\Backend\ManageResort\PackageType;
use App\Livewire\Backend\ManageResort\ServiceType;
use App\Livewire\Backend\ManageRoom\BedType;
use App\Livewire\Backend\ManageRoom\ManageRoom;
use App\Livewire\Backend\ManageRoom\ViewType;
use App\Livewire\Backend\Payments\Payments;
use App\Livewire\Backend\Reviews\Reviews;
use App\Livewire\Backend\Settings\ContactInfoSettings;
use App\Livewire\Backend\Settings\MailSettings;
use App\Livewire\Backend\Settings\PasswordSettings;
use App\Livewire\Backend\Settings\PaymentSettings;
use App\Livewire\Backend\Settings\SiteSettings;
use App\Livewire\Backend\Settings\SocialSettings;
use App\Livewire\Backend\Users\UsersManage;
use Illuminate\Support\Facades\Route;



// for admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin'], 'as' => 'admin.'], function () {
  /* Admin Dashboard */
  Route::get('dashboard', Dashboard::class)->name('dashboard');

  // for settings group routes
  Route::prefix('/settings')->name('settings.')->group(function () {
    Route::get('/site', SiteSettings::class)->name('site');
    Route::get('/mail', MailSettings::class)->name('mail');
    Route::get('/payment', PaymentSettings::class)->name('payment');
    Route::get('/password', PasswordSettings::class)->name('password');
    Route::get('/social', SocialSettings::class)->name('social');
    Route::get('/contact-info', ContactInfoSettings::class)->name('contact-info');
  });


  // for event manage group routes
  Route::prefix('/event-manage')->name('event-manage.')->group(function () {
    Route::get('/hero', EventHero::class)->name('hero');
    Route::get('/services', EventServices::class)->name('services');
  });


  // for content manage group routes
  Route::prefix('/content-manage')->name('content-manage.')->group(function () {
    Route::get('/features-images', FeaturesImages::class)->name('features-images');
  });


  // for resort manage group routes
  Route::prefix('/resort-manage')->name('resort-manage.')->group(function () {
    Route::get('/', ManageResort::class)->name('index');
    Route::get('/service-type', ServiceType::class)->name('service-type');
    Route::get('/package-type', PackageType::class)->name('package-type');
    Route::get('/manage-facilities', ManageFacilities::class)->name('manage-facilities');
    Route::get('/{resort}/facilities', ManageResortFacilities::class)
      ->name('facilities.manage');
    Route::get('/resorts/{id}', [ResortController::class, 'show'])->name('resorts.show');
  });



  // for room manage group routes
  Route::prefix('/room-manage')->name('room-manage.')->group(function () {
    Route::get('/', ManageRoom::class)->name('index');
    Route::get('/view-type', ViewType::class)->name('view-type');
    Route::get('/bed-type', BedType::class)->name('bed-type');
    Route::get('/room/{id}', [RoomController::class, 'show'])->name('room.show');
  });




  // for booking info routes
  Route::prefix('/booking-info')->name('booking-info.')->group(function () {
    Route::get('/pending', BookingList::class)->name('pending')->defaults('status', 'pending');
    Route::get('/confirm', BookingList::class)->name('confirm')->defaults('status', 'confirmed');
    Route::get('/cancelled', BookingList::class)->name('cancelled')->defaults('status', 'cancelled');
    Route::get('/completed', BookingList::class)->name('completed')->defaults('status', 'completed');
  });



  // for payment route below
  Route::prefix('/payments')->name('payments.')->group(function () {
    Route::get('/', Payments::class)->name('index');
  });


  // for contact info
  Route::prefix('/contact-info')->name('contact-info.')->group(function () {
    Route::get('/', ContactInfo::class)->name('index');
  });


  // for payment route below
  Route::prefix('/reviews')->name('reviews.')->group(function () {
    Route::get('/', Reviews::class)->name('index');
  });


  // coupon management route
  Route::get('coupons', ManageCoupons::class)->name('coupons');



  // users management routes
  Route::prefix('/users')->name('users.')->group(function () {
    Route::get('/manage', UsersManage::class)->name('manage');
  });
});


Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
