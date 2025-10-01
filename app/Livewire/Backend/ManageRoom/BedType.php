<?php

namespace App\Livewire\Backend\ManageRoom;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\RoomBedType;

use App\Services\RoomManage\BedTypeManageService;


class BedType extends BaseComponent
{
    public $bt_infos, $bt_item, $bt_id, $type_name, $search;


    public $editMode = false;
    public $perPage = 10;
    public $loaded;
    public $lastId = null;
    public $hasMore = true;

    protected $roomBT;

    protected $listeners = ['deleteBT'];


    public function boot(BedTypeManageService $roomBT)
    {
        $this->roomBT = $roomBT;
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
        return view('livewire.backend.manage-room.bed-type', [
            'infos' => $this->loaded
        ]);
    }




    /* reset input file */
    public function resetInputFields()
    {
        $this->bt_item = '';
        $this->type_name = '';
        $this->resetErrorBag();
    }



    public function store()
    {
        $this->validate();

        $this->roomBT->saveRoomBT([
            'type_name' => $this->type_name,
        ]);

        $this->bt_infos =  $this->roomBT->getAllRoomBTData();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Bed Type saved Successfully!', 'success');
        $this->resetLoaded();
    }



    public function edit($id)
    {
        $this->editMode = true;
        $this->bt_item = $this->roomBT->getBTSingleData($id);

        if (!$this->bt_item) {
            $this->toast('Bed Type not found!', 'error');
            return;
        }

        $this->type_name = $this->bt_item->type_name;
    }

    public function update()
    {
        $this->validate();

        if (!$this->bt_item) {
            $this->toast('Bed Type not found!', 'error');
            return;
        }


        $this->roomBT->updateRoomBTSingleData($this->bt_item, [
            'type_name'       => $this->type_name,
        ]);



        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Bed Type has been updated successfully!', 'success');
        $this->resetLoaded();
    }



    /* process while update */
    public function searchBT()
    {
        $this->resetLoaded();
    }




    // Load more function
    public function loadMore()
    {
        if (!$this->hasMore) return;

        $query = RoomBedType::query();
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



    public function deleteBT($id)
    {
        $this->roomBT->deleteRoomBT($id);



        $this->toast('Bed Type has been deleted!', 'success');
        $this->resetLoaded();
    }
}
