<?php

namespace App\Http\Controllers\API;

use App\Services\BkashService;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
    protected $bkash;

    public function __construct(BkashService $bkash)
    {
        $this->bkash = $bkash;
    }

    public function getToken()
    {
        return response()->json($this->bkash->getToken());
    }

    public function createPayment(Request $request)
    {
        $amount = $request->amount;
        $bookingId = $request->bookingId;
        return response()->json($this->bkash->createPayment($amount, $bookingId));
    }

    public function executePayment(Request $request)
    {
        $paymentID = $request->paymentID;
        return response()->json($this->bkash->executePayment($paymentID));
    }
}
