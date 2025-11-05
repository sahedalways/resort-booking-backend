<?php

namespace App\Livewire\Backend\ManageRoom;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\Room;
use Livewire\WithFileUploads;
use App\Services\RoomManage\RoomManageService;


class ManageRoom extends BaseComponent
{
    public $search;
    public $items;
    public $itemId;
    public $resorts = [];
    public $bedTypes = [];
    public $viewTypes = [];
    public $serviceTypes = [];
    public $item;

    public $resort_id;
    public $name;
    public $desc;
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
    public $perPage = 10;
    public $loaded;
    public $lastId = null;
    public $hasMore = true;
    protected $manageRoom;

    public $images = [];
    public $removedImages = [];
    public $imageInputs = [0];

    public $roomServices = [];


    public $roomServicesInputs = [0];

    public $rateDetails = [];
    public $rateDetailsInputs = [0];


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
            'desc' => 'required|string|max:255',
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
        $this->serviceTypes = $this->manageRoom->getServicesTypes();
        $this->loaded = collect();
        $this->loadMore();
    }


    public function render()
    {
        return view('livewire.backend.manage-room.manage-room', [
            'infos' => $this->loaded
        ]);
    }



    /* reset input file */
    public function resetInputFields()
    {
        // Clear all input fields
        $this->name = null;
        $this->bed_type_id = null;
        $this->itemId = null;
        $this->view_type_id = null;
        $this->area = null;
        $this->price = null;
        $this->desc = null;
        $this->adult_cap = 1;
        $this->resort_id = 1;
        $this->child_cap = 0;
        $this->price_per = null;
        $this->package_name = null;
        $this->is_active = true;
        $this->images = [];
        $this->removedImages = [];
        $this->roomServices = [];
        $this->rateDetails = [];

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
            'desc' => $this->desc,
        ]);


        $this->items =  $this->manageRoom->getAllRoomsData();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Room info saved Successfully!', 'success');
        $this->resetLoaded();
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
        $this->desc = $this->item->desc;
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
            'desc' => $this->desc,
            'is_active' => $this->is_active,
        ]);

        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Room info has been updated successfully!', 'success');
        $this->resetLoaded();
    }



    /* process while update */
    public function searchRoom()
    {
        $this->resetLoaded();
    }




    // Load more function
    public function loadMore()
    {
        if (!$this->hasMore) return;

        $query = Room::with(['resort', 'images', 'bedType', 'viewType']);

        if ($this->search && $this->search != '') {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $query->where(function ($q) {
            $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhereHas('resort', function ($resortQuery) {
                    $resortQuery->where('name', 'like', '%' . $this->search . '%');
                });
        });

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




    public function deleteRoom($id)
    {
        $this->manageRoom->deleteRoom($id);


        $this->toast('Room info has been deleted!', 'success');
        $this->resetLoaded();
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



        $this->toast('Status updated successfully!', 'success');
        $this->resetLoaded();
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


        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');


        $this->toast('Images saved successfully!', 'success');
        $this->resetLoaded();
    }



    public function manageRoomServices($id)
    {
        $this->resetInputFields();
        $this->itemId = $id;

        $savedData = $this->manageRoom->getRoomServices($id);


        $this->roomServices = $savedData->mapWithKeys(function ($item, $key) {
            return [$key => $item->service_id];
        })->toArray();


        $this->roomServicesInputs = array_keys($this->roomServices);


        $this->roomServicesInputs[] = count($this->roomServices);
    }




    public function addRoomServiceInput()
    {
        $this->roomServicesInputs[] = count($this->roomServicesInputs);
    }

    public function removeRoomServiceInput($index)
    {
        unset($this->roomServices[$index]);
        $this->roomServicesInputs = array_values(array_diff($this->roomServicesInputs, [$index]));
    }


    public function saveRoomService()
    {

        if (!empty($this->roomServices)) {
            $this->validate([
                'roomServices' => 'array',
                'roomServices.*' => 'required|distinct',
            ], [
                'roomServices.*.distinct' => 'Duplicate services are not allowed.',
                'roomServices.*.required' => 'Please select a service.',
            ]);
        }

        $this->manageRoom->saveRoomServices($this->itemId, $this->roomServices);


        $this->editMode = false;


        $this->dispatch('closemodal');


        $this->toast('Room services saved successfully!', 'success');
        $this->resetLoaded();
    }



    public function manageRoomRateDetails($id)
    {
        $this->resetInputFields();
        $this->itemId = $id;

        $savedData = $this->manageRoom->getRoomRateDetails($id);


        $this->rateDetails = $savedData->mapWithKeys(function ($item, $key) {
            return [
                $key => [
                    'title' => $item->title,
                    'is_active' => $item->is_active,
                ]
            ];
        })->toArray();


        $this->rateDetailsInputs = array_keys($this->rateDetails);


        $this->rateDetailsInputs[] = count($this->rateDetails);
        $this->rateDetails[count($this->rateDetails)] = ['title' => '', 'is_active' => 1];
    }




    public function addRateDetailsInput()
    {
        $this->rateDetailsInputs[] = count($this->rateDetailsInputs);
    }

    public function removeRateDetailsInput($index)
    {
        unset($this->rateDetails[$index]);
        $this->rateDetailsInputs = array_values(array_diff($this->rateDetailsInputs, [$index]));
    }


    public function saveRateDetails()
    {

        $this->validate([
            'rateDetails.*.title' => 'required|string|max:255',
            'rateDetails.*.is_active' => 'nullable|boolean',
        ]);


        $this->manageRoom->saveRoomRateDetails($this->itemId, $this->rateDetails);



        $this->editMode = false;


        $this->dispatch('closemodal');


        $this->toast('Room rate details saved successfully!', 'success');
        $this->resetLoaded();
    }
}
