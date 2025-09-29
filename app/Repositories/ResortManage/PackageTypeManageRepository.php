<?php

namespace App\Repositories\ResortManage;

use App\Models\ResortPackageType;


class PackageTypeManageRepository
{


  public function getAllResortPTData()
  {
    return ResortPackageType::query()
      ->latest()
      ->get(['id', 'type_name', 'icon', 'is_refundable']);
  }


  public function getPTSingleData(int $id): ?ResortPackageType
  {

    return ResortPackageType::where('id', $id)->first();
  }


  public function updateResortPTSingleData(ResortPackageType $ptItem, array $data): ?ResortPackageType
  {
    $ptItem->update([
      'type_name'     => $data['type_name'],
      'icon'          => $data['icon'],
      'is_refundable' => $data['is_refundable'] ?? false,
    ]);

    return $ptItem->fresh();
  }



  public function saveResortPT(array $data): ?ResortPackageType
  {
    $ptItem = new ResortPackageType();

    $ptItem->type_name = $data['type_name'] ?? null;
    $ptItem->icon = $data['icon'] ?? null;
    $ptItem->is_refundable = $data['is_refundable'] ?? true;

    $ptItem->save();

    return $ptItem;
  }


  public function deleteResortPT(int $id)
  {
    $data = $this->getPTSingleData($id);
    $data->delete();
  }
}
