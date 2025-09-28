<?php

namespace App\Services;

use App\Models\EventHero;
use App\Repositories\EventRepository;


class EventService
{
  protected $repository;

  public function __construct(EventRepository $repository)
  {
    $this->repository = $repository;
  }


  /**
   * Save event hero
   *
   * @param array $data
   * @return EventHero
   */
  public function saveEventHeroSettings(array $data): EventHero
  {

    return $this->repository->saveEventHeroSettings($data);
  }
}
