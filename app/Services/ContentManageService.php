<?php

namespace App\Services;


use App\Repositories\ContentManageRepository;
use App\Repositories\EventRepository;


class ContentManageService
{
  protected $repository;

  public function __construct(ContentManageRepository $repository)
  {
    $this->repository = $repository;
  }



  public function getFeatureImages()
  {
    return $this->repository->getFeatureImageItem();
  }



  public function saveFeatureImages(array $data)
  {
    return $this->repository->saveFeatureImages($data);
  }
}
