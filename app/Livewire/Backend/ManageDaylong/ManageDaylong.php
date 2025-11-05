<?php

namespace App\Livewire\Backend\ManageDaylong;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\Room;
use Livewire\WithFileUploads;
use App\Services\RoomManage\RoomManageService;


class ManageDaylong extends BaseComponent
{
    public $search;
    public $items;
    public $itemId;
    public $resorts = [];
    public $serviceTypes = [];
    public $item;

    public $resort_id;
    public $name = 'Day Long';
    public $is_daylong = 1;
    public $capacity_type = 'none';
    public $desc;
    public $price;

    public $price_per =  'Per Person';
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
            'name' => 'nullable|string|max:255',
            'desc' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'price_per' => 'nullable|string|max:255',
            'is_active'  => 'boolean',
        ];
    }



    public function mount()
    {
        $this->resorts = $this->manageRoom->getResorts();
        $this->serviceTypes = $this->manageRoom->getServicesTypes();
        $this->loaded = collect();
        $this->loadMore();
    }


    public function render()
    {
        return view('livewire.backend.manage-daylong.manage-daylong', [
            'infos' => $this->loaded
        ]);
    }


    /* reset input file */
    public function resetInputFields()
    {
        // Clear all input fields
        $this->name = null;
        $this->itemId = null;
        $this->price = null;
        $this->resort_id = null;
        $this->desc = null;
        $this->price_per = null;
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

        $this->manageRoom->saveDayLongData([
            'resort_id' => $this->resort_id,
            'name' => $this->name,
            'price' => $this->price,
            'price_per' => $this->price_per,
            'is_active' => $this->is_active,
            'desc' => $this->desc,
            'capacity_type' => $this->capacity_type,
            'is_daylong' => $this->is_daylong,
        ]);


        $this->items =  $this->manageRoom->getAllRoomsData();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Day-Long info saved Successfully!', 'success');
        $this->resetLoaded();
    }



    public function edit($id)
    {
        $this->editMode = true;
        $this->item = $this->manageRoom->getRoomSingleData($id);

        if (!$this->item) {
            $this->toast('Day-Long info not found!', 'error');
            return;
        }

        $this->resort_id = $this->item->resort_id;
        $this->name = $this->item->name;
        $this->price = $this->item->price;
        $this->price_per = $this->item->price_per;
        $this->desc = $this->item->desc;
        $this->is_active = (bool) $this->item->is_active;
    }

    public function update()
    {
        $this->validate();

        if (!$this->item) {
            $this->toast('Day-Long info not found!', 'error');
            return;
        }


        $this->manageRoom->updateDayLongSingleData($this->item, [
            'resort_id'   => $this->resort_id,
            'price'       => $this->price,
            'price_per'   => $this->price_per,
            'desc' => $this->desc,
            'is_active' => $this->is_active,
        ]);

        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Day-Long info has been updated successfully!', 'success');
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

        $query = Room::with(['resort', 'images'])
            ->where('is_daylong', true);

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


        $this->toast('Day-Long info has been deleted!', 'success');
        $this->resetLoaded();
    }



    public function toggleActive($id)
    {
        $item = $this->manageRoom->getRoomSingleData($id);

        if (!$item) {
            $this->toast('Day-Long not found!', 'error');
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


        $this->toast('Day-Long services saved successfully!', 'success');
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


        $this->toast('Day-Long rate details saved successfully!', 'success');
        $this->resetLoaded();
    }
}
