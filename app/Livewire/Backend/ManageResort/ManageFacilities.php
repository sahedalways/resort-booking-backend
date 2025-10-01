<?php

namespace App\Livewire\Backend\ManageResort;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\ResortRoomFacility;
use App\Services\ResortMange\FacilitiesManageService;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;


class ManageFacilities extends BaseComponent
{
    public $items, $item, $itemId, $name, $icon, $old_icon, $search;


    public $editMode = false;

    public $perPage = 10;
    public $loaded;
    public $lastId = null;
    public $hasMore = true;

    protected $facilitiesManageService;

    protected $listeners = ['deleteItem'];

    public $serviceTypes = [];
    public $options = [];
    public $removedOptions = [];

    public $optionInputs = [0];


    public function boot(FacilitiesManageService $facilitiesManageService)
    {
        $this->facilitiesManageService = $facilitiesManageService;
    }


    protected $rules = [
        'name' => 'required|string|max:255|unique:resort_room_facilities,name',
        'icon' => 'required|string|max:255',
    ];




    public function mount()
    {
        $this->serviceTypes =  $this->facilitiesManageService->getAllServiceTypes();
        $this->loaded = collect();
        $this->loadMore();
    }


    public function render()
    {
        return view('livewire.backend.manage-resort.manage-facilities', [
            'infos' => $this->loaded
        ]);
    }



    /* reset input file */
    public function resetInputFields()
    {
        $this->item = '';
        $this->icon = '';
        $this->name = '';
        $this->old_icon = '';
        $this->options = [];

        $this->removedOptions = [];
        $this->optionInputs = [0];
        $this->resetErrorBag();
    }


    public function store()
    {
        $this->validate();

        $this->facilitiesManageService->saveFacilityData([
            'name' => $this->name,
            'icon'  => $this->icon,
        ]);

        $this->items =  $this->facilitiesManageService->getAllFacilitiesData();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Facility item saved Successfully!', 'success');
        $this->resetLoaded();
    }





    public function edit($id)
    {
        $this->editMode = true;
        $this->item = $this->facilitiesManageService->getFacilitySingleData($id);

        if (!$this->item) {
            $this->toast('Facility item not found!', 'error');
            return;
        }

        $this->name = $this->item->name;
        $this->icon = $this->item->icon;
        $this->old_icon = $this->item->icon;
    }

    public function update()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('resort_room_facilities', 'name')->ignore($this->item->id),
            ],
            'icon' => 'required|string|max:255',
        ]);


        if (!$this->item) {
            $this->toast('Facility item not found!', 'error');
            return;
        }


        $this->facilitiesManageService->updateFacilitySingleData($this->item, [
            'name'       => $this->name,
            'icon' => $this->icon,
        ]);



        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Facility item has been updated successfully!', 'success');
        $this->resetLoaded();
    }



    /* process while update */
    public function searchFacility()
    {
        $this->resetLoaded();
    }




    // Load more function
    public function loadMore()
    {
        if (!$this->hasMore) return;

        $query = ResortRoomFacility::query();
        if ($this->search && $this->search != '') {
            $query->where('name', 'like', '%' . $this->search . '%');
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



    public function deleteItem($id)
    {
        $this->facilitiesManageService->deleteFacilityData($id);



        $this->toast('Facility item has been deleted!', 'success');
        $this->resetLoaded();
    }




    public function manageFacilityOptions($id)
    {
        $this->resetInputFields();
        $this->itemId = $id;

        $savedOptions = $this->facilitiesManageService->getFacilityOptions($id);


        $this->options = $savedOptions->map(fn($option) => $option->service_id)->toArray();


        $this->optionInputs = [];
        foreach ($this->options as $key => $item) {
            $this->optionInputs[] = $key;
        }


        $this->optionInputs[] = count($this->options);
        $this->options[count($this->options)] = null;
    }




    public function addOptionInput()
    {
        $this->optionInputs[] = count($this->optionInputs);
    }

    public function removeOptionInput($index)
    {

        if (isset($this->options[$index]) && is_string($this->options[$index])) {
            $this->removedOptions[] = $this->options[$index];
        }


        unset($this->options[$index]);
        $this->optionInputs = array_values(array_diff($this->optionInputs, [$index]));
    }


    public function saveOptions()
    {

        $this->facilitiesManageService->saveFacilityOptions($this->itemId, $this->options, $this->removedOptions);



        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');


        $this->toast('Options saved successfully!', 'success');
        $this->resetLoaded();
    }
}
