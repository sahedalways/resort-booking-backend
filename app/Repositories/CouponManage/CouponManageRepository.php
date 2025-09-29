<?php

namespace App\Repositories\CouponManage;

use App\Models\Coupon;




class CouponManageRepository
{


  public function getAllCouponManageData()
  {
    return Coupon::query()
      ->latest()
      ->get(['id', 'code', 'discount_value', 'status']);
  }


  public function getSingleCoupon(int $id): ?Coupon
  {

    return Coupon::where('id', $id)->first();
  }


  public function updateCouponManageSingleData(Coupon $item, array $data): ?Coupon
  {
    $item->update([
      'code'     => $data['code'],
      'discount_value'          => $data['discount_value'],
      'status'          => $data['status'],
    ]);

    return $item->fresh();
  }



  public function saveCouponManage(array $data): ?Coupon
  {
    $item = new Coupon();

    $item->code = $data['code'] ?? null;
    $item->discount_value = $data['discount_value'] ?? null;
    $item->status = $data['status'] ?? null;


    $item->save();

    return $item;
  }


  public function deleteCouponManage(int $id)
  {
    $data = $this->getSingleCoupon($id);
    $data->delete();
  }
}
