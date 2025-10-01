<?php

namespace App\Livewire\Backend\ManageResort;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\ResortPackageType;
use App\Services\ResortMange\PackageTypeManageService;



class PackageType extends BaseComponent
{
    public $pt_infos, $pt_item, $pt_id, $type_name, $icon, $old_icon, $is_refundable = true,  $search;

    public $perPage = 10;
    public $loaded;
    public $lastId = null;
    public $hasMore = true;
    public $editMode = false;

    protected $resortPT;

    protected $listeners = ['deletePT'];


    public function boot(PackageTypeManageService $resortPT)
    {
        $this->resortPT = $resortPT;
    }


    protected $rules = [
        'type_name' => 'required|string|max:255',
        'icon' => 'required|string|max:255',
        'is_refundable' => 'required|boolean',
    ];




    public function mount()
    {

        $this->loaded = collect();
        $this->loadMore();
    }


    public function render()
    {
        return view('livewire.backend.manage-resort.package-type', [
            'infos' => $this->loaded
        ]);
    }




    /* reset input file */
    public function resetInputFields()
    {
        $this->pt_item = '';
        $this->icon = '';
        $this->type_name = '';
        $this->old_icon = '';
        $this->is_refundable = true;
        $this->resetErrorBag();
    }


    /* store event service data */
    public function store()
    {
        $this->validate();

        $this->resortPT->saveResortPT([
            'type_name' => $this->type_name,
            'icon'  => $this->icon,
            'is_refundable'  => $this->is_refundable,
        ]);

        $this->pt_infos =  $this->resortPT->getAllResortPTData();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Package Type saved Successfully!', 'success');
        $this->resetLoaded();
    }





    public function edit($id)
    {
        $this->editMode = true;
        $this->pt_item = $this->resortPT->getPTSingleData($id);

        if (!$this->pt_item) {
            $this->toast('Package Type not found!', 'error');
            return;
        }

        $this->type_name = $this->pt_item->type_name;
        $this->icon = $this->pt_item->icon;
        $this->old_icon = $this->pt_item->icon;
        $this->is_refundable = $this->pt_item->is_refundable;
    }

    public function update()
    {
        $this->validate();

        if (!$this->pt_item) {
            $this->toast('Package Type not found!', 'error');
            return;
        }


        $this->resortPT->updateResortPTSingleData($this->pt_item, [
            'type_name'       => $this->type_name,
            'icon' => $this->icon,
            'is_refundable' => $this->is_refundable,
        ]);



        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Package Type has been updated successfully!', 'success');
        $this->resetLoaded();
    }



    /* process while update */
    public function searchPT()
    {
        $this->resetLoaded();
    }




    // Load more function
    public function loadMore()
    {
        if (!$this->hasMore) return;

        $query = ResortPackageType::query();
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





    public function deletePT($id)
    {
        $this->resortPT->deleteResortPT($id);

        $this->toast('Package Type has been deleted!', 'success');
        $this->resetLoaded();
    }
}
