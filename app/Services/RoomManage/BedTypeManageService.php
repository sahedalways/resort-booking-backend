<?php

namespace App\Services\RoomManage;

use App\Models\RoomBedType;
use App\Repositories\RoomManage\BedTypeManageRepository;


class BedTypeManageService
{
  protected $repository;

  public function __construct(BedTypeManageRepository $repository)
  {
    $this->repository = $repository;
  }



  public function getAllRoomBTData()
  {

    return $this->repository->getAllRoomBTData();
  }


  public function getBTSingleData(int $id): ?RoomBedType
  {

    return $this->repository->getBTSingleData($id);
  }


  public function updateRoomBTSingleData(RoomBedType $bt_item, array $data): RoomBedType
  {
    return $this->repository->updateRoomBTSingleData($bt_item, $data);
  }


  public function saveRoomBT(array $data): RoomBedType
  {

    return $this->repository->saveRoomBT($data);
  }


  public function deleteRoomBT(int $id)
  {
    return $this->repository->deleteRoomBT($id);
  }
}
