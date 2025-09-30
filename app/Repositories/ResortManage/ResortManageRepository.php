<?php

namespace App\Repositories\ResortManage;

use App\Models\Resort;


class ResortManageRepository
{


  public function getAllResortData()
  {
    return Resort::query()
      ->latest()
      ->get();
  }


  public function getResortSingleData(int $id): ?Resort
  {

    return Resort::where('id', $id)->first();
  }

  public function updateResortSingleData(Resort $item, array $data): ?Resort
  {
    $item->update([
      'name'     => $data['name'],
      'distance'     => $data['distance'],
      'location'     => $data['location'],
      'desc'     => $data['desc'],
      'd_check_in'     => $data['d_check_in'],
      'd_check_out'     => $data['d_check_out'],
      'n_check_in'     => $data['n_check_in'],
      'n_check_out'     => $data['n_check_out'],

    ]);

    return $item->fresh();
  }



  public function saveResortData(array $data): ?Resort
  {
    $item = new Resort();


    $item->name = $data['name'] ?? null;
    $item->distance = $data['distance'] ?? null;
    $item->location = $data['location'] ?? null;
    $item->desc = $data['desc'] ?? null;
    $item->d_check_in = $data['d_check_in'] ?? null;
    $item->d_check_out = $data['d_check_out'] ?? null;
    $item->n_check_in = $data['n_check_in'] ?? null;
    $item->n_check_out = $data['n_check_out'] ?? null;


    $item->save();

    return $item;
  }


  public function deleteResortData(int $id)
  {
    $data = $this->getResortSingleData($id);
    $data->delete();
  }
}
