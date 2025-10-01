<?php

namespace App\Services\RoomManage;

use App\Models\Room;
use App\Repositories\RoomManage\RoomManageRepository;


class RoomManageService
{
  protected $repository;

  public function __construct(RoomManageRepository $repository)
  {
    $this->repository = $repository;
  }



  public function getAllRoomsData()
  {

    return $this->repository->getAllRoomsData();
  }


  public function getRoomSingleData(int $id): ?Room
  {

    return $this->repository->getRoomSingleData($id);
  }


  public function updateRoomSingleData(Room $item, array $data): Room
  {
    return $this->repository->updateRoomSingleData($item, $data);
  }


  public function saveRoomsData(array $data): Room
  {

    return $this->repository->saveRoomsData($data);
  }


  public function deleteRoom(int $id)
  {
    return $this->repository->deleteRoom($id);
  }


  public function getResorts()
  {
    return $this->repository->getResorts();
  }


  public function getBedTypes()
  {
    return $this->repository->getBedTypes();
  }


  public function getViewTypes()
  {
    return $this->repository->getViewTypes();
  }


  public function saveRoomImagesGallery(int $itemId, array $images, array $removedImages)
  {
    return $this->repository->saveRoomImagesGallery($itemId, $images,  $removedImages);
  }


  public function getRoomImagesGallery(int $itemId)
  {
    return $this->repository->getRoomImagesGallery($itemId);
  }
}
