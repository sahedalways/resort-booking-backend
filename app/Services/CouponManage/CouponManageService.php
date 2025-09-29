<?php

namespace App\Services\CouponManage;

use App\Models\Coupon;
use App\Repositories\CouponManage\CouponManageRepository;




class CouponManageService
{
  protected $repository;

  public function __construct(CouponManageRepository $repository)
  {
    $this->repository = $repository;
  }



  public function getAllCouponManageData()
  {

    return $this->repository->getAllCouponManageData();
  }


  public function getSingleCoupon(int $id)
  {

    return $this->repository->getSingleCoupon($id);
  }


  public function updateCouponManageSingleData(Coupon $stItem, array $data): Coupon
  {
    return $this->repository->updateCouponManageSingleData($stItem, $data);
  }


  public function saveCouponManage(array $data): Coupon
  {

    return $this->repository->saveCouponManage($data);
  }


  public function deleteCouponManage(int $id)
  {
    return $this->repository->deleteCouponManage($id);
  }
}
