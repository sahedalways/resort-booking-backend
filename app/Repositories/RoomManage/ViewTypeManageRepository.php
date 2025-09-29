<?php

namespace App\Repositories\RoomManage;


use App\Models\RoomViewType;


class ViewTypeManageRepository
{


  public function getAllRoomViewTypeData()
  {
    return RoomViewType::query()
      ->latest()
      ->get(['id', 'type_name']);
  }


  public function getVTSingleData(int $id)
  {
    return RoomViewType::where('id', $id)->first();
  }


  public function updateRoomVTSingleData(RoomViewType $vtItem, array $data): ?RoomViewType
  {
    $vtItem->update($data);
    return $vtItem;
  }




  public function saveRoomVT(array $data): ?RoomViewType
  {
    $vtItem = new RoomViewType();

    $vtItem->type_name = $data['type_name'] ?? null;

    $vtItem->save();

    return $vtItem;
  }


  public function deleteRoomVT(int $id)
  {
    $data = $this->getVTSingleData($id);

    $data->delete();
  }
}
