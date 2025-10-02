<?php

namespace App\Services;

use App\Repositories\ReviewManageRepository;


class ReviewManageService
{
  protected $repository;

  public function __construct(ReviewManageRepository $repository)
  {
    $this->repository = $repository;
  }


  public function deleteReview($id)
  {

    return $this->repository->deleteReviewItem($id);
  }
}
