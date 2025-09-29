<?php

namespace App\Repositories;


use App\Models\FeatureImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;


class ContentManageRepository
{


  /**
   * Get or create feature image  (id = 1).
   *
   * @return \App\Models\FeatureImage
   */
  public function getFeatureImageItem(): FeatureImage
  {
    return FeatureImage::firstOrNew(['id' => 1]);
  }



  public function saveFeatureImages(array $data): ?FeatureImage
  {
    $settings = $this->getFeatureImageItem();


    if (isset($data['resort_image']) && $data['resort_image'] instanceof UploadedFile) {
      $ext = $data['resort_image']->getClientOriginalExtension();
      $data['resort_image']->storeAs('image/content/features', 'resort_image.' . $ext, 'public');
      $settings->resort_image = $ext;
    }

    if (isset($data['event_image']) && $data['event_image'] instanceof UploadedFile) {
      $ext = $data['event_image']->getClientOriginalExtension();
      $data['event_image']->storeAs('image/content/features', 'event_image.' . $ext, 'public');
      $settings->event_image = $ext;
    }


    $settings->save();


    return $settings;
  }
}
