<?php

namespace App\Repositories;

use App\Models\Payment;


class PaymentManageRepository
{

  public function getSinglePaymentInfo($id): Payment
  {
    return Payment::where('id', $id)->first();
  }



  public function deletePaymentItem(int $id)
  {
    $data = $this->getSinglePaymentInfo($id);
    $data->delete();
  }
}
