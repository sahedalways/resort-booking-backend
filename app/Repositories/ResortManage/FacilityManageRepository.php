<?php

namespace App\Repositories\ResortManage;

use App\Models\ResortRoomFacility;
use App\Models\ResortRoomFacilityOption;


class FacilityManageRepository
{


  public function getAllFacilitiesData()
  {
    return ResortRoomFacility::query()
      ->latest()
      ->get(['id', 'name', 'icon']);
  }


  public function getFacilitySingleData(int $id): ?ResortRoomFacility
  {

    return ResortRoomFacility::where('id', $id)->first();
  }


  public function updateFacilitySingleData(ResortRoomFacility $item, array $data): ?ResortRoomFacility
  {
    $item->update([
      'name'     => $data['name'],
      'icon'          => $data['icon'],
    ]);

    return $item->fresh();
  }



  public function saveFacilityData(array $data): ?ResortRoomFacility
  {
    $item = new ResortRoomFacility();

    $item->name = $data['name'] ?? null;
    $item->icon = $data['icon'] ?? null;

    $item->save();

    return $item;
  }


  public function deleteFacilityData(int $id)
  {
    $data = $this->getFacilitySingleData($id);
    $data->delete();
  }



  public function saveFacilityOptions(int $itemId, array $options, array $removedOptions): void
  {

    ResortRoomFacilityOption::where('facility_id', $itemId)->delete();


    foreach ($options as $item) {
      ResortRoomFacilityOption::create([
        'facility_id' => $itemId,
        'name'            => $item,
      ]);
    }
  }



  public function getFacilityOptions(int $itemId)
  {
    return ResortRoomFacilityOption::where('facility_id', $itemId)->latest()->get();
  }
}
