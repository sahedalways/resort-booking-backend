<?php

namespace App\Services\RoomManage;

use App\Models\RoomViewType;
use App\Repositories\RoomManage\ViewTypeManageRepository;



class ViewTypeManageService
{
  protected $repository;

  public function __construct(ViewTypeManageRepository $repository)
  {
    $this->repository = $repository;
  }



  public function getAllRoomViewTypeData()
  {

    return $this->repository->getAllRoomViewTypeData();
  }


  public function getVTSingleData(int $id)
  {

    return $this->repository->getVTSingleData($id);
  }


  public function updateRoomVTSingleData(RoomViewType $vtItem, array $data): RoomViewType
  {
    return $this->repository->updateRoomVTSingleData($vtItem, $data);
  }


  public function saveRoomVT(array $data): RoomViewType
  {

    return $this->repository->saveRoomVT($data);
  }


  public function deleteRoomVT(int $id)
  {
    return $this->repository->deleteRoomVT($id);
  }
}
