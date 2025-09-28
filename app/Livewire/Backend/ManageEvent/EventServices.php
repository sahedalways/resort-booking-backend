<?php

namespace App\Livewire\Backend\ManageEvent;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\EventService as ModelsEventService;
use App\Services\EventService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;
use Livewire\WithFileUploads;

class EventServices extends BaseComponent
{
    public $eventServices, $service,  $service_id, $title, $description, $thumbnail, $search;
    use WithFileUploads;

    public $editMode = false;
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;

    protected $eventService;

    protected $listeners = ['deleteService'];


    public function boot(EventService $eventService)
    {
        $this->eventService = $eventService;
    }


    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'thumbnail' => 'required|image|max:2048',
    ];



    public function mount()
    {

        $this->eventServices = new EloquentCollection();


        $this->loadEventServices();
    }


    public function render()
    {
        return view('livewire.backend.manage-event.event-services');
    }


    /* reset input file */
    public function resetInputFields()
    {
        $this->service = '';
        $this->title = '';
        $this->description = '';
        $this->thumbnail = '';
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
    }



    /* process while update */
    public function updated()
    {
        $this->reloadEventServices();
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
        $this->thumbnail = getFileUrl($this->service->thumbnailUrl);
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if (!$this->eventService) {
            $this->toast('Event service not found!', 'error');
            return;
        }


        $this->repository->updateEventService($this->eventService, [
            'title'       => $this->title,
            'description' => $this->description,
            'thumbnail'   => $this->thumbnail,
        ]);


        $this->refresh();
        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Event service has been updated successfully!', 'success');
    }



    /* process while update */
    public function searchService()
    {
        if ($this->search != '') {
            $this->eventServices = ModelsEventService::where('title', 'like', '%' . $this->search)
                ->latest()
                ->get();
        } elseif ($this->search == '') {
            $this->eventServices = new EloquentCollection();
        }

        $this->reloadEventServices();
    }



    /* refresh the page */
    public function refresh()
    {
        /* if search query or order filter is empty */
        if ($this->search == '') {
            $this->eventServices = $this->eventServices->fresh();
        }
    }
    public function loadEventServices()
    {
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $eventServiceslist = $this->filterdata();
        $this->eventServices->push(...$eventServiceslist->items());
        if ($this->hasMorePages = $eventServiceslist->hasMorePages()) {
            $this->nextCursor = $eventServiceslist->nextCursor()->encode();
        }
        $this->currentCursor = $eventServiceslist->cursor();
    }


    public function filterdata()
    {
        $query = ModelsEventService::query();

        if ($this->search && $this->search != '') {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm);
            });
        }

        $data = $query->latest()
            ->cursorPaginate(10, ['*'], 'cursor', $this->nextCursor ? Cursor::fromEncoded($this->nextCursor) : null);

        return $data;
    }


    public function reloadEventServices()
    {
        $this->eventServices = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $eventServices = $this->filterdata();
        $this->eventServices->push(...$eventServices->items());
        if ($this->hasMorePages = $eventServices->hasMorePages()) {
            $this->nextCursor = $eventServices->nextCursor()->encode();
        }
        $this->currentCursor = $eventServices->cursor();
    }


    public function deleteService($id)
    {
        $this->eventService->deleteService($id);

        $this->reloadEventServices();

        $this->toast('Service has been deleted!', 'success');
    }
}
