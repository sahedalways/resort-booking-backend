<?php

namespace App\Services\ResortMange;

use App\Models\ResortServiceType;
use App\Repositories\ResortManage\ServiceTypeManageRepository;




class ServiceTypeManageService
{
  protected $repository;

  public function __construct(ServiceTypeManageRepository $repository)
  {
    $this->repository = $repository;
  }



  public function getAllResortSTData()
  {

    return $this->repository->getAllResortSTData();
  }


  public function getSTSingleData(int $id)
  {

    return $this->repository->getSTSingleData($id);
  }


  public function updateResortSTSingleData(ResortServiceType $stItem, array $data): ResortServiceType
  {
    return $this->repository->updateResortSTSingleData($stItem, $data);
  }


  public function saveResortST(array $data): ResortServiceType
  {

    return $this->repository->saveResortST($data);
  }


  public function deleteResortST(int $id)
  {
    return $this->repository->deleteResortST($id);
  }
}
