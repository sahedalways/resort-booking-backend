<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\API\BaseController;
use App\Models\BookingInfo;
use App\Models\Resort;
use App\Services\BkashService;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
  protected $bkash;

  public function __construct(BkashService $bkash)
  {
    $this->bkash = $bkash;
  }

  public function paymentSuccess(Request $request)
  {
    $paymentID = $request->paymentID;
    $frontendUrl = env('FRONTEND_URL') ?? 'http://localhost:3000';

    $response = $this->bkash->executePayment($paymentID);

    if ($response['status'] === 'success') {
      $booking = BookingInfo::where('invoice', $response['merchantInvoiceNumber'])->first();
      if ($booking) {
        $booking->status = 'completed';
        $booking->save();
      }


      return redirect()->away($frontendUrl . '/booking/success');
    } else {
      return redirect()->away($frontendUrl . '/booking/failed');
    }
  }
}
