<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewManageRepository
{

  public function getSingleReviewItem($id): Review
  {
    return Review::where('id', $id)->first();
  }



  public function deleteReviewItem(int $id)
  {
    $data = $this->getSingleReviewItem($id);
    $data->delete();
  }
}
