<?php

namespace App\Services\ResortMange;

use App\Models\ResortPackageType;
use App\Repositories\ResortManage\PackageTypeManageRepository;





class PackageTypeManageService
{
  protected $repository;

  public function __construct(PackageTypeManageRepository $repository)
  {
    $this->repository = $repository;
  }



  public function getAllResortPTData()
  {

    return $this->repository->getAllResortPTData();
  }


  public function getPTSingleData(int $id): ?ResortPackageType
  {

    return $this->repository->getPTSingleData($id);
  }


  public function updateResortPTSingleData(ResortPackageType $pt_item, array $data): ResortPackageType
  {
    return $this->repository->updateResortPTSingleData($pt_item, $data);
  }


  public function saveResortPT(array $data): ResortPackageType
  {

    return $this->repository->saveResortPT($data);
  }


  public function deleteResortPT(int $id)
  {
    return $this->repository->deleteResortPT($id);
  }
}
