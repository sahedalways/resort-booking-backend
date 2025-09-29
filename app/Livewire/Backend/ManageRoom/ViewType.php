<?php

namespace App\Livewire\Backend\ManageRoom;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\RoomViewType;

use App\Services\RoomManage\BedTypeManageService;
use App\Services\RoomManage\ViewTypeManageService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;


class ViewType extends BaseComponent
{
    public $vt_infos, $vt_item, $vt_id, $type_name, $search;


    public $editMode = false;
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;

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

        $this->vt_infos = new EloquentCollection();


        $this->loadRoomVTData();
    }


    public function render()
    {
        return view('livewire.backend.manage-room.view-type');
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
    }



    /* process while update */
    public function updated()
    {
        $this->reloadRoomVTData();
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


        $this->refresh();
        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('View Type has been updated successfully!', 'success');
    }



    /* process while update */
    public function searchVT()
    {
        if ($this->search != '') {

            $this->vt_infos = RoomViewType::where('type_name', 'like', '%' . $this->search)
                ->latest()
                ->get();
        } elseif ($this->search == '') {
            $this->vt_infos = new EloquentCollection();
        }

        $this->reloadRoomVTData();
    }



    /* refresh the page */
    public function refresh()
    {

        if ($this->search == '') {
            $this->vt_infos = $this->vt_infos->fresh();
        }
    }
    public function loadRoomVTData()
    {
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $vtList = $this->filterdata();
        $this->vt_infos->push(...$vtList->items());
        if ($this->hasMorePages = $vtList->hasMorePages()) {
            $this->nextCursor = $vtList->nextCursor()->encode();
        }
        $this->currentCursor = $vtList->cursor();
    }


    public function filterdata()
    {
        $query = RoomViewType::query();

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


    public function reloadRoomVTData()
    {
        $this->vt_infos = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $data = $this->filterdata();
        $this->vt_infos->push(...$data->items());
        if ($this->hasMorePages = $data->hasMorePages()) {
            $this->nextCursor = $data->nextCursor()->encode();
        }
        $this->currentCursor = $data->cursor();
    }


    public function deleteVT($id)
    {
        $this->roomVT->deleteRoomVT($id);

        $this->reloadRoomVTData();

        $this->toast('View Type has been deleted!', 'success');
    }
}
