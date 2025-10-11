<?php

namespace App\Services;

use App\Models\BookingInfo;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Http;

class BkashService
{
  protected $baseUrl;
  protected $username;
  protected $password;
  protected $appKey;
  protected $appSecret;

  public function __construct()
  {
    $credentials = PaymentSetting::where('gateway', 'bkash')->where('is_active', 1)->first();

    if (!$credentials) {
      throw new \Exception('bKash credentials not found.');
    }


    $this->baseUrl = $credentials->base_url;
    $this->username = $credentials->username;
    $this->password = $credentials->password;
    $this->appKey = $credentials->app_key;
    $this->appSecret = $credentials->app_secret;
  }

  // 1️⃣ Generate Token
  public function getToken()
  {
    $response = Http::withHeaders([
      'username' => $this->username,
      'password' => $this->password,
    ])->post($this->baseUrl . '/token/grant', [
      'app_key' => $this->appKey,
      'app_secret' => $this->appSecret,
    ]);

    return $response->json();
  }

  // 2️⃣ Create Payment
  public function createPayment($amount, $bookingId)
  {
    $tokenData = $this->getToken();
    $accessToken = $tokenData['id_token'];
    $invoice = 'BX-' . now()->format('Ymd-His') . '-' . $bookingId;
    $callbackURL = route('payment.success', [], true);

    $booking = BookingInfo::find($bookingId);
    $booking->invoice = $invoice;
    $booking->save();


    $response = Http::withToken($accessToken)
      ->post($this->baseUrl . '/payment/create', [
        'amount' => $amount,
        'intent' => 'sale',
        'merchantInvoiceNumber' => $invoice,
        'callbackURL' => $callbackURL,
      ]);

    return $response->json();
  }

  // 3️⃣ Execute Payment
  public function executePayment($paymentID)
  {
    $tokenData = $this->getToken();
    $accessToken = $tokenData['id_token'];

    $response = Http::withToken($accessToken)
      ->post($this->baseUrl . '/payment/execute', [
        'paymentID' => $paymentID,
      ]);

    return $response->json();
  }
}
