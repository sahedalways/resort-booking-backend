<?php

namespace App\Repositories\RoomManage;

use App\Models\Resort;
use App\Models\Room;
use App\Models\RoomBedType;
use App\Models\RoomViewType;




class RoomManageRepository
{


  public function getAllRoomsData()
  {
    return Room::with(['resort', 'images', 'bedType', 'viewType'])
      ->latest()
      ->get();
  }


  public function getRoomSingleData(int $id): ?Room
  {

    return Room::where('id', $id)->first();
  }


  public function updateRoomSingleData(Room $item, array $data): ?Room
  {
    $item->update([
      'resort_id'   => $data['resort_id'] ?? $item->resort_id,
      'name'        => $data['name'] ?? $item->name,
      'bed_type_id' => $data['bed_type_id'] ?? $item->bed_type_id,
      'view_type_id' => $data['view_type_id'] ?? $item->view_type_id,
      'area'        => $data['area'] ?? $item->area,
      'price'       => $data['price'] ?? $item->price,
      'adult_cap'   => $data['adult_cap'] ?? $item->adult_cap,
      'child_cap'   => $data['child_cap'] ?? $item->child_cap,
      'price_per'   => $data['price_per'] ?? $item->price_per,
      'package_name' => $data['package_name'] ?? $item->package_name,
      'is_active' => $data['is_active'] ?? $item->is_active,
    ]);


    return $item->fresh();
  }



  public function saveRoomsData(array $data): ?Room
  {
    $item = new Room();

    $item->resort_id    = $data['resort_id'] ?? null;
    $item->name         = $data['name'] ?? null;
    $item->bed_type_id  = $data['bed_type_id'] ?? null;
    $item->view_type_id = $data['view_type_id'] ?? null;
    $item->area         = $data['area'] ?? null;
    $item->price        = $data['price'] ?? null;
    $item->adult_cap    = $data['adult_cap'] ?? 1;
    $item->child_cap    = $data['child_cap'] ?? 0;
    $item->price_per    = $data['price_per'] ?? null;
    $item->package_name = $data['package_name'] ?? null;
    $item->is_active = $data['is_active'] ?? null;


    $item->save();

    return $item;
  }


  public function deleteRoom(int $id)
  {
    $data = $this->getRoomSingleData($id);
    $data->delete();
  }


  public function getResorts()
  {
    return Resort::select('id', 'name')->get();
  }


  public function getBedTypes()
  {
    return RoomBedType::select('id', 'type_name')->get();
  }

  public function getViewTypes()
  {
    return RoomViewType::select('id', 'type_name')->get();
  }
}
