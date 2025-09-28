<?php

namespace App\Repositories;

use App\Models\EventHero;
use App\Models\EventService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;


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


  public function getAllEventServices()
  {
    return EventService::query()
      ->latest()
      ->get(['id', 'title', 'thumbnail', 'description']);
  }


  public function saveAllEventService(array $data): EventService
  {
    $eventServ = new EventService();
    $eventServ->title    = $data['title'];
    $eventServ->description    = $data['description'];


    if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {

      $filename = Str::uuid() . '.' . $data['thumbnail']->getClientOriginalExtension();


      $img = Image::read($data['thumbnail']->getRealPath());


      $path = storage_path('app/public/image/event/services/' . $filename);
      $img->save($path);

      $eventServ->thumbnail = 'image/event/services/' . $filename;
    }

    $eventServ->save();

    return $eventServ;
  }


  public function findEventService($id): ?EventService
  {
    return EventService::where('id', $id)->first();
  }



  public function updateEventService(EventService $eventService, array $data): ?EventService
  {
    $eventService->title    = $data['title'];
    $eventService->description    = $data['description'];


    if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {

      if ($eventService->thumbnail && Storage::disk('public')->exists($eventService->thumbnail)) {
        Storage::disk('public')->delete($eventService->thumbnail);
      }


      $filename = Str::uuid() . '.' . $data['thumbnail']->getClientOriginalExtension();


      $img = Image::read($data['thumbnail']->getRealPath());


      $path = storage_path('app/public/image/event/services/' . $filename);
      $img->save($path);

      $eventService->thumbnail = 'image/event/services/' . $filename;
    }


    $eventService->save();

    return $eventService;
  }
}
