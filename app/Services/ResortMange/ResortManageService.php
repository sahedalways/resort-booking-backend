<?php

namespace App\Services\ResortMange;

use App\Models\Resort;
use App\Repositories\ResortManage\ResortManageRepository;



class ResortManageService
{
  protected $repository;

  public function __construct(ResortManageRepository $repository)
  {
    $this->repository = $repository;
  }



  public function getAllResortData()
  {

    return $this->repository->getAllResortData();
  }


  public function getResortSingleData(int $id)
  {

    return $this->repository->getResortSingleData($id);
  }


  public function updateResortSingleData(Resort $item, array $data): Resort
  {
    return $this->repository->updateResortSingleData($item, $data);
  }


  public function saveResortData(array $data): Resort
  {

    return $this->repository->saveResortData($data);
  }


  public function deleteResortData(int $id)
  {
    return $this->repository->deleteResortData($id);
  }
}
