<?php

namespace App\Services;

use App\Models\EventHero;
use App\Models\EventService as ModelsEventService;
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



  public function getAllEventServices()
  {

    return $this->repository->getAllEventServices();
  }


  /**
   * Save event service
   *
   * @param array $data
   * @return ModelsEventService
   */
  public function saveAllEventService(array $data): ModelsEventService
  {

    return $this->repository->saveAllEventService($data);
  }


  public function getEventService($id): ?ModelsEventService
  {
    return $this->repository->findEventService($id);
  }


  public function updateEventService(ModelsEventService $eventService, array $data): ModelsEventService
  {

    return $this->repository->updateEventService($eventService, $data);
  }
}
