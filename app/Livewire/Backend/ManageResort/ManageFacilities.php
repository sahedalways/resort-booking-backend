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
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;

    protected $facilitiesManageService;

    protected $listeners = ['deleteItem'];

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

        $this->items = new EloquentCollection();


        $this->loadFacilitiesData();
    }


    public function render()
    {
        return view('livewire.backend.manage-resort.manage-facilities');
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
    }



    /* process while update */
    public function updated()
    {
        $this->reloadFacilitiesData();
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


        $this->refresh();
        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Facility item has been updated successfully!', 'success');
    }



    /* process while update */
    public function searchFacility()
    {
        if ($this->search != '') {
            $this->items = ResortRoomFacility::where('name', 'like', '%' . $this->search)
                ->latest()
                ->get();
        } elseif ($this->search == '') {
            $this->items = new EloquentCollection();
        }

        $this->reloadFacilitiesData();
    }



    /* refresh the page */
    public function refresh()
    {

        if ($this->search == '') {
            $this->items = $this->items->fresh();
        }
    }
    public function loadFacilitiesData()
    {
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $list = $this->filterdata();
        $this->items->push(...$list->items());
        if ($this->hasMorePages = $list->hasMorePages()) {
            $this->nextCursor = $list->nextCursor()->encode();
        }
        $this->currentCursor = $list->cursor();
    }


    public function filterdata()
    {
        $query = ResortRoomFacility::query();

        if ($this->search && $this->search != '') {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm);
            });
        }

        $data = $query->latest()
            ->cursorPaginate(10, ['*'], 'cursor', $this->nextCursor ? Cursor::fromEncoded($this->nextCursor) : null);

        return $data;
    }


    public function reloadFacilitiesData()
    {
        $this->items = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $data = $this->filterdata();
        $this->items->push(...$data->items());
        if ($this->hasMorePages = $data->hasMorePages()) {
            $this->nextCursor = $data->nextCursor()->encode();
        }
        $this->currentCursor = $data->cursor();
    }


    public function deleteItem($id)
    {
        $this->facilitiesManageService->deleteFacilityData($id);

        $this->reloadFacilitiesData();

        $this->toast('Facility item has been deleted!', 'success');
    }





    public function manageFacilityOptions($id)
    {
        $this->resetInputFields();
        $this->itemId = $id;

        $savedOptions = $this->facilitiesManageService->getFacilityOptions($id);

        $this->options = $savedOptions->pluck('name')->toArray();


        $this->optionInputs = [];


        foreach ($this->options as $key => $item) {
            $this->optionInputs[] = $key;
        }
        $this->optionInputs[] = count($this->options);
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


        $this->refresh();
        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');


        $this->toast('Options saved successfully!', 'success');
    }
}
