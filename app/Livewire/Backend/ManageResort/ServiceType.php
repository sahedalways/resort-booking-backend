<?php

namespace App\Livewire\Backend\ManageResort;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\ResortServiceType;
use App\Services\ResortMange\ServiceTypeManageService;


class ServiceType extends BaseComponent
{
    public $stItem, $st_id, $type_name, $icon, $old_icon, $search;
    public $perPage = 10;
    public $loaded;
    public $lastId = null;
    public $hasMore = true;
    public $editMode = false;

    protected $resortST;
    protected $listeners = ['deleteST'];

    public function mount()
    {
        $this->loaded = collect(); // collection start
        $this->loadMore();
    }

    public function boot(ServiceTypeManageService $resortST)
    {
        $this->resortST = $resortST;
    }

    protected $rules = [
        'type_name' => 'required|string|max:255',
        'icon' => 'required|string|max:255',
    ];

    public function render()
    {
        return view('livewire.backend.manage-resort.service-type', [
            'infos' => $this->loaded
        ]);
    }

    // Reset input fields
    public function resetInputFields()
    {
        $this->stItem = '';
        $this->icon = '';
        $this->type_name = '';
        $this->old_icon = '';
        $this->resetErrorBag();
    }

    // Store
    public function store()
    {
        $this->validate();

        $this->resortST->saveResortST([
            'type_name' => $this->type_name,
            'icon' => $this->icon,
        ]);

        $this->resetInputFields();
        $this->dispatch('closemodal');
        $this->toast('Service Type saved Successfully!', 'success');

        $this->resetLoaded();
    }

    // Edit
    public function edit($id)
    {
        $this->editMode = true;
        $this->stItem = $this->resortST->getSTSingleData($id);

        if (!$this->stItem) {
            $this->toast('Service type not found!', 'error');
            return;
        }

        $this->type_name = $this->stItem->type_name;
        $this->icon = $this->stItem->icon;
        $this->old_icon = $this->stItem->icon;
    }

    // Update
    public function update()
    {
        $this->validate();

        if (!$this->stItem) {
            $this->toast('Service type not found!', 'error');
            return;
        }

        $this->resortST->updateResortSTSingleData($this->stItem, [
            'type_name' => $this->type_name,
            'icon' => $this->icon,
        ]);

        $this->resetInputFields();
        $this->editMode = false;
        $this->dispatch('closemodal');
        $this->toast('Service type has been updated successfully!', 'success');

        $this->resetLoaded();
    }

    // Search
    public function searchST()
    {
        $this->resetLoaded();
    }

    // Load more function
    public function loadMore()
    {
        if (!$this->hasMore) return;

        $query = ResortServiceType::query();
        if ($this->search && $this->search != '') {
            $query->where('type_name', 'like', '%' . $this->search . '%');
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

    // Delete
    public function deleteST($id)
    {
        $this->resortST->deleteResortST($id);
        $this->toast('Service type has been deleted!', 'success');

        $this->resetLoaded();
    }
}
