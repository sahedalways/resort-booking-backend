<?php

namespace App\Livewire\Backend\ManageRoom;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\RoomViewType;
use App\Services\RoomManage\ViewTypeManageService;


class ViewType extends BaseComponent
{
    public $vt_infos, $vt_item, $vt_id, $type_name, $search;


    public $editMode = false;
    public $perPage = 10;
    public $loaded;
    public $lastId = null;
    public $hasMore = true;

    protected $roomVT;

    protected $listeners = ['deleteVT'];


    public function boot(ViewTypeManageService $roomVT)
    {
        $this->roomVT = $roomVT;
    }


    protected $rules = [
        'type_name' => 'required|string|max:255',
    ];


    public function mount()
    {

        $this->loaded = collect();
        $this->loadMore();
    }


    public function render()
    {
        return view('livewire.backend.manage-room.view-type', [
            'infos' => $this->loaded
        ]);
    }



    /* reset input file */
    public function resetInputFields()
    {
        $this->vt_item = '';
        $this->type_name = '';
        $this->resetErrorBag();
    }



    public function store()
    {
        $this->validate();

        $this->roomVT->saveRoomVT([
            'type_name' => $this->type_name,
        ]);

        $this->vt_infos =  $this->roomVT->getAllRoomViewTypeData();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('View Type saved Successfully!', 'success');
        $this->resetLoaded();
    }






    public function edit($id)
    {
        $this->editMode = true;
        $this->vt_item = $this->roomVT->getVTSingleData($id);

        if (!$this->vt_item) {
            $this->toast('View Type not found!', 'error');
            return;
        }

        $this->type_name = $this->vt_item->type_name;
    }

    public function update()
    {
        $this->validate();

        if (!$this->vt_item) {
            $this->toast('View Type not found!', 'error');
            return;
        }


        $this->roomVT->updateRoomVTSingleData($this->vt_item, [
            'type_name'       => $this->type_name,
        ]);


        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('View Type has been updated successfully!', 'success');
        $this->resetLoaded();
    }



    /* process while update */
    public function searchVT()
    {
        $this->resetLoaded();
    }




    // Load more function
    public function loadMore()
    {
        if (!$this->hasMore) return;

        $query = RoomViewType::query();
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




    public function deleteVT($id)
    {
        $this->roomVT->deleteRoomVT($id);



        $this->toast('View Type has been deleted!', 'success');
        $this->resetLoaded();
    }
}
