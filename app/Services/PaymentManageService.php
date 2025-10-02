<?php

namespace App\Services;

use App\Repositories\PaymentManageRepository;


class PaymentManageService
{
  protected $repository;

  public function __construct(PaymentManageRepository $repository)
  {
    $this->repository = $repository;
  }


  public function deletePaymentItem($id)
  {

    return $this->repository->deletePaymentItem($id);
  }
}
