<?php

namespace App\Livewire\Backend\ManageRoom;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\Room;
use Livewire\WithFileUploads;
use App\Services\RoomManage\RoomManageService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;


class ManageRoom extends BaseComponent
{
    public $search;
    public $items;
    public $itemId;
    public $resorts = [];
    public $bedTypes = [];
    public $viewTypes = [];
    public $item;

    public $resort_id;
    public $name;
    public $bed_type_id;
    public $area;
    public $view_type_id;
    public $price;
    public $adult_cap = 1;
    public $child_cap = 0;
    public $price_per;
    public $package_name;
    public $is_active = true;

    public $editMode = false;
    public $nextCursor;
    protected $currentCursor;

    public $hasMorePages;
    protected $manageRoom;

    public $images = [];
    public $removedImages = [];
    public $imageInputs = [0];


    protected $listeners = ['deleteRoom'];

    use WithFileUploads;

    public function boot(RoomManageService $manageRoom)
    {
        $this->manageRoom = $manageRoom;
    }


    public function getRules()
    {
        return [
            'name' => 'required|string|max:255',
            'bed_type_id' => 'required|exists:room_bed_types,id',
            'view_type_id' => 'required|exists:room_view_types,id',
            'area' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'adult_cap' => 'required|integer|min:1',
            'child_cap' => 'required|integer|min:0',
            'price_per' => 'required|string|max:255',
            'package_name' => 'required|string|max:255',
            'is_active'  => 'boolean',
        ];
    }



    public function mount()
    {
        $this->resorts = $this->manageRoom->getResorts();
        $this->bedTypes = $this->manageRoom->getBedTypes();
        $this->viewTypes = $this->manageRoom->getViewTypes();

        $this->items = new EloquentCollection();


        $this->loadRoomsData();
    }


    public function render()
    {
        return view('livewire.backend.manage-room.manage-room');
    }


    /* reset input file */
    public function resetInputFields()
    {
        // Clear all input fields
        $this->name = null;
        $this->bed_type_id = null;
        $this->view_type_id = null;
        $this->area = null;
        $this->price = null;
        $this->adult_cap = 1;
        $this->child_cap = 0;
        $this->price_per = null;
        $this->package_name = null;
        $this->is_active = true;
        $this->images = [];
        $this->removedImages = [];

        // Clear validation errors
        $this->resetErrorBag();
    }




    public function store()
    {
        $this->validate($this->getRules());

        $this->manageRoom->saveRoomsData([
            'resort_id' => $this->resort_id,
            'name' => $this->name,
            'bed_type_id' => $this->bed_type_id,
            'view_type_id' => $this->view_type_id,
            'area' => $this->area,
            'price' => $this->price,
            'adult_cap' => $this->adult_cap,
            'child_cap' => $this->child_cap,
            'price_per' => $this->price_per,
            'package_name' => $this->package_name,
            'is_active' => $this->is_active,
        ]);


        $this->items =  $this->manageRoom->getAllRoomsData();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Room info saved Successfully!', 'success');
    }



    /* process while update */
    public function updated()
    {
        $this->reloadRoomsData();
    }



    public function edit($id)
    {
        $this->editMode = true;
        $this->item = $this->manageRoom->getRoomSingleData($id);

        if (!$this->item) {
            $this->toast('Room info not found!', 'error');
            return;
        }

        $this->resort_id = $this->item->resort_id;
        $this->name = $this->item->name;
        $this->bed_type_id = $this->item->bed_type_id;
        $this->view_type_id = $this->item->view_type_id;
        $this->area = $this->item->area;
        $this->price = $this->item->price;
        $this->adult_cap = $this->item->adult_cap;
        $this->child_cap = $this->item->child_cap;
        $this->price_per = $this->item->price_per;
        $this->package_name = $this->item->package_name;
        $this->is_active = (bool) $this->item->is_active;
    }

    public function update()
    {
        $this->validate();

        if (!$this->item) {
            $this->toast('Room info not found!', 'error');
            return;
        }


        $this->manageRoom->updateRoomSingleData($this->item, [
            'resort_id'   => $this->resort_id,
            'name'        => $this->name,
            'bed_type_id' => $this->bed_type_id,
            'view_type_id' => $this->view_type_id,
            'area'        => $this->area,
            'price'       => $this->price,
            'adult_cap'   => $this->adult_cap,
            'child_cap'   => $this->child_cap,
            'price_per'   => $this->price_per,
            'package_name' => $this->package_name,
            'is_active' => $this->is_active,
        ]);


        $this->refresh();
        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Room info has been updated successfully!', 'success');
    }



    /* process while update */
    public function searchRoom()
    {
        if ($this->search != '') {

            $this->items = Room::with(['resort', 'images', 'bedType', 'viewType'])
                ->where('name', 'like', '%' . $this->search . '%')
                ->latest()
                ->get();
        } elseif ($this->search == '') {
            $this->items = new EloquentCollection();
        }

        $this->reloadRoomsData();
    }



    /* refresh the page */
    public function refresh()
    {

        if ($this->search == '') {
            $this->items = $this->items->fresh();
        }
    }
    public function loadRoomsData()
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
        $query = Room::with(['resort', 'images', 'bedType', 'viewType']);

        if ($this->search && $this->search != '') {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm);
            });
        }

        $data = $query->latest()
            ->cursorPaginate(
                10,
                ['*'],
                'cursor',
                $this->nextCursor ? Cursor::fromEncoded($this->nextCursor) : null
            );

        return $data;
    }


    public function reloadRoomsData()
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


    public function deleteRoom($id)
    {
        $this->manageRoom->deletRoom($id);

        $this->reloadRoomsData();

        $this->toast('Room info has been deleted!', 'success');
    }



    public function toggleActive($id)
    {
        $item = $this->manageRoom->getRoomSingleData($id);

        if (!$item) {
            $this->toast('Room not found!', 'error');
            return;
        }

        $item->is_active = $item->is_active ? 0 : 1;
        $item->save();


        $this->items =  $this->manageRoom->getAllRoomsData();

        $this->refresh();

        $this->toast('Status updated successfully!', 'success');
    }



    public function addRoomImages($id)
    {
        $this->resetInputFields();
        $this->itemId = $id;

        $savedImages = $this->manageRoom->getRoomImagesGallery($id);

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

        $this->manageRoom->saveRoomImagesGallery($this->itemId, $this->images, $this->removedImages);


        $this->refresh();
        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');


        $this->toast('Images saved successfully!', 'success');
    }
}
