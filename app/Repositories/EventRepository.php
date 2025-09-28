<?php

namespace App\Repositories;

use App\Models\EventHero;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;


class EventRepository
{
  /**
   * Get or create event hero (id = 1).
   *
   * @return \App\Models\EventHero
   */
  public function getEventHeroSetting(): EventHero
  {
    return EventHero::firstOrNew(['id' => 1]);
  }


  public function saveEventHeroSettings(array $data): EventHero
  {
    $settings = $this->getEventHeroSetting();

    $settings->title = $data['title'] ?? null;
    $settings->sub_title = $data['sub_title'] ?? null;
    $settings->phone_number = $data['phone_number'] ?? null;

    if (isset($data['hero_image']) && $data['hero_image'] instanceof UploadedFile) {
      $image = $data['hero_image'];

      $img = Image::read($image);

      $filename = 'event-hero.webp';

      $path = storage_path('app/public/image/event/' . $filename);
      $img->save($path);

      $settings->hero_image = 'webp';
    }

    $settings->save();

    return $settings;
  }
}
