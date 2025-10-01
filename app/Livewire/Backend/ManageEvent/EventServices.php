<?php

namespace App\Livewire\Backend\ManageEvent;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\EventService as ModelsEventService;
use App\Services\EventService;
use Livewire\WithFileUploads;


class EventServices extends BaseComponent
{
    public $eventServices, $service,  $service_id, $title, $description, $thumbnail, $old_thumbnail, $search;
    public $images = [];
    public $removedImages = [];
    public $imageInputs = [0];


    use WithFileUploads;
    public $perPage = 1;
    public $loaded;
    public $lastId = null;
    public $hasMore = true;

    public $editMode = false;


    protected $eventService;

    protected $listeners = ['deleteService'];


    public function boot(EventService $eventService)
    {
        $this->eventService = $eventService;
    }


    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'thumbnail' => 'required|image|max:2048',
    ];



    public function mount()
    {
        $this->loaded = collect();
        $this->loadMore();
    }



    public function render()
    {
        return view('livewire.backend.manage-event.event-services', [
            'infos' => $this->loaded
        ]);
    }




    /* reset input file */
    public function resetInputFields()
    {
        $this->service = '';
        $this->title = '';
        $this->description = '';
        $this->thumbnail = '';
        $this->old_thumbnail = '';
        $this->service_id = '';
        $this->images = [];
        $this->imageInputs = [0];
        $this->resetErrorBag();
    }


    /* store event service data */
    public function store()
    {
        $this->validate();

        $this->eventService->saveAllEventService([
            'title' => $this->title,
            'description'  => $this->description,
            'thumbnail'      => $this->thumbnail,
        ]);

        $this->eventServices =  $this->eventService->getAllEventServices();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Event service saved Successfully!', 'success');

        $this->resetLoaded();
    }





    /* view event service details to update */
    public function edit($id)
    {
        $this->editMode = true;
        $this->service = $this->eventService->getEventService($id);

        if (!$this->service) {
            $this->toast('Event service not found!', 'error');
            return;
        }

        $this->title = $this->service->title;
        $this->description = $this->service->description;
        $this->old_thumbnail = $this->service->thumbnail;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|max:2048',
        ]);


        if (!$this->service) {
            $this->toast('Event service not found!', 'error');
            return;
        }


        $this->eventService->updateEventService($this->service, [
            'title'       => $this->title,
            'description' => $this->description,
            'thumbnail'   => $this->thumbnail,
        ]);



        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Event service has been updated successfully!', 'success');

        $this->resetLoaded();
    }



    /* process while update */
    public function searchService()
    {

        $this->resetLoaded();
    }




    // Load more function
    public function loadMore()
    {
        if (!$this->hasMore) return;

        $query = ModelsEventService::query();
        if ($this->search && $this->search != '') {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->lastId) {
            $query->where('id', '<', $this->lastId);
        }

        $items = $query->orderBy('id', 'desc')
            ->limit($this->perPage)
            ->get();



        if ($items->count() < $this->perPage) {
            $this->hasMore = false;
        }



        if ($items->count()) {
            $this->lastId = $items->last()->id;
            $this->loaded = $this->loaded->merge($items);
        }
    }

    // Reset loaded collection
    private function resetLoaded()
    {
        $this->loaded = collect();
        $this->lastId = null;
        $this->hasMore = true;
        $this->loadMore();
    }






    public function deleteService($id)
    {
        $this->eventService->deleteEventService($id);



        $this->toast('Service has been deleted!', 'success');

        $this->resetLoaded();
    }


    public function addServiceImages($id)
    {
        $this->resetInputFields();
        $this->service_id = $id;

        $savedImages = $this->eventService->getServiceImagesGallery($id);

        $this->images = $savedImages->pluck('image')->toArray();


        $this->imageInputs = [];


        foreach ($this->images as $key => $image) {
            $this->imageInputs[] = $key;
        }
        $this->imageInputs[] = count($this->images);
    }


    public function addImageInput()
    {
        $this->imageInputs[] = count($this->imageInputs);
    }

    public function removeImageInput($index)
    {

        if (isset($this->images[$index]) && is_string($this->images[$index])) {
            $this->removedImages[] = $this->images[$index];
        }


        unset($this->images[$index]);
        $this->imageInputs = array_values(array_diff($this->imageInputs, [$index]));
    }


    public function saveImages()
    {

        $this->eventService->saveServiceImagesGallery($this->service_id, $this->images, $this->removedImages);


        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');


        $this->toast('Images saved successfully!', 'success');

        $this->resetLoaded();
    }
}
