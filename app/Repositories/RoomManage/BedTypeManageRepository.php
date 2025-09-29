<?php

namespace App\Repositories\RoomManage;

use App\Models\RoomBedType;




class BedTypeManageRepository
{


  public function getAllRoomBTData()
  {
    return RoomBedType::query()
      ->latest()
      ->get(['id', 'type_name']);
  }


  public function getBTSingleData(int $id): ?RoomBedType
  {

    return RoomBedType::where('id', $id)->first();
  }


  public function updateRoomBTSingleData(RoomBedType $btItem, array $data): ?RoomBedType
  {
    $btItem->update([
      'type_name'     => $data['type_name'],
    ]);

    return $btItem->fresh();
  }



  public function saveRoomBT(array $data): ?RoomBedType
  {
    $btItem = new RoomBedType();

    $btItem->type_name = $data['type_name'] ?? null;


    $btItem->save();

    return $btItem;
  }


  public function deleteRoomBT(int $id)
  {
    $data = $this->getBTSingleData($id);
    $data->delete();
  }
}
