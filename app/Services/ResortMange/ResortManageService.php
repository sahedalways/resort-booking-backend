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



  public function saveResortImagesGallery(int $itemId, array $images, array $removedImages)
  {
    return $this->repository->saveResortImagesGallery($itemId, $images,  $removedImages);
  }


  public function getResortImagesGallery(int $itemId)
  {
    return $this->repository->getResortImagesGallery($itemId);
  }

  public function getPackageTypes()
  {
    return $this->repository->getPackageTypes();
  }



  public function saveFactOptions(int $itemId, array $options)
  {
    return $this->repository->saveFactOptions($itemId, $options);
  }


  public function getFactOptions(int $itemId)
  {
    return $this->repository->getFactOptions($itemId);
  }
}
