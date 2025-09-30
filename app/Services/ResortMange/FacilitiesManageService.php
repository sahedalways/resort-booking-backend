<?php

namespace App\Services\ResortMange;

use App\Models\ResortRoomFacility;
use App\Repositories\ResortManage\FacilityManageRepository;


class FacilitiesManageService
{
  protected $repository;

  public function __construct(FacilityManageRepository $repository)
  {
    $this->repository = $repository;
  }



  public function getAllFacilitiesData()
  {

    return $this->repository->getAllFacilitiesData();
  }


  public function getFacilitySingleData(int $id)
  {

    return $this->repository->getFacilitySingleData($id);
  }


  public function updateFacilitySingleData(ResortRoomFacility $stItem, array $data): ResortRoomFacility
  {
    return $this->repository->updateFacilitySingleData($stItem, $data);
  }


  public function saveFacilityData(array $data): ResortRoomFacility
  {

    return $this->repository->saveFacilityData($data);
  }


  public function deleteFacilityData(int $id)
  {
    return $this->repository->deleteFacilityData($id);
  }


  public function saveFacilityOptions(int $itemId, array $options, array $removedOptions)
  {
    return $this->repository->saveFacilityOptions($itemId, $options,  $removedOptions);
  }


  public function getFacilityOptions(int $itemId)
  {
    return $this->repository->getFacilityOptions($itemId);
  }


  public function getAllServiceTypes()
  {
    return $this->repository->getAllServiceTypes();
  }
}
