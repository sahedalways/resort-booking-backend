<?php

namespace App\Repositories\ResortManage;


use App\Models\ResortServiceType;


class ServiceTypeManageRepository
{


  public function getAllResortSTData()
  {
    return ResortServiceType::query()
      ->latest()
      ->get(['id', 'type_name', 'icon']);
  }


  public function getSTSingleData(int $id): ?ResortServiceType
  {
    return ResortServiceType::find($id);
  }


  public function updateResortSTSingleData(ResortServiceType $stItem, array $data): ?ResortServiceType
  {
    $stItem->type_name    = $data['type_name'];
    $stItem->icon    = $data['icon'];


    $stItem->save();

    return $stItem;
  }


  public function saveResortST(array $data): ?ResortServiceType
  {
    $stItem = new ResortServiceType();

    $stItem->type_name = $data['type_name'] ?? null;
    $stItem->icon = $data['icon'] ?? null;

    $stItem->save();

    return $stItem;
  }


  public function deleteResortST(int $id)
  {
    $data = $this->getSTSingleData($id);
    $data->delete();
  }
}
