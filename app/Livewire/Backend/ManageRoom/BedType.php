<?php

namespace App\Livewire\Backend\ManageRoom;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\RoomBedType;

use App\Services\RoomManage\BedTypeManageService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;


class BedType extends BaseComponent
{
    public $bt_infos, $bt_item, $bt_id, $type_name, $search;


    public $editMode = false;
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;

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

        $this->bt_infos = new EloquentCollection();


        $this->loadRoomBTData();
    }


    public function render()
    {
        return view('livewire.backend.manage-room.bed-type');
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
    }



    /* process while update */
    public function updated()
    {
        $this->reloadRoomBTData();
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


        $this->refresh();
        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Bed Type has been updated successfully!', 'success');
    }



    /* process while update */
    public function searchBT()
    {
        if ($this->search != '') {

            $this->bt_infos = RoomBedType::where('type_name', 'like', '%' . $this->search)
                ->latest()
                ->get();
        } elseif ($this->search == '') {
            $this->bt_infos = new EloquentCollection();
        }

        $this->reloadRoomBTData();
    }



    /* refresh the page */
    public function refresh()
    {

        if ($this->search == '') {
            $this->bt_infos = $this->bt_infos->fresh();
        }
    }
    public function loadRoomBTData()
    {
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $ptList = $this->filterdata();
        $this->bt_infos->push(...$ptList->items());
        if ($this->hasMorePages = $ptList->hasMorePages()) {
            $this->nextCursor = $ptList->nextCursor()->encode();
        }
        $this->currentCursor = $ptList->cursor();
    }


    public function filterdata()
    {
        $query = RoomBedType::query();

        if ($this->search && $this->search != '') {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('type_name', 'like', $searchTerm);
            });
        }

        $data = $query->latest()
            ->cursorPaginate(10, ['*'], 'cursor', $this->nextCursor ? Cursor::fromEncoded($this->nextCursor) : null);

        return $data;
    }


    public function reloadRoomBTData()
    {
        $this->bt_infos = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $data = $this->filterdata();
        $this->bt_infos->push(...$data->items());
        if ($this->hasMorePages = $data->hasMorePages()) {
            $this->nextCursor = $data->nextCursor()->encode();
        }
        $this->currentCursor = $data->cursor();
    }


    public function deleteBT($id)
    {
        $this->roomBT->deleteRoomBT($id);

        $this->reloadRoomBTData();

        $this->toast('Bed Type has been deleted!', 'success');
    }
}
