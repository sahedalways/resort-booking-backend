<?php

namespace App\Livewire\Backend\ManageResort;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\Resort;

use App\Services\ResortMange\ResortManageService;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;


class ManageResort extends BaseComponent
{
    public $items, $item, $itemId, $name, $distance, $location, $packageTypeId, $desc, $d_check_in, $d_check_out, $n_check_in, $n_check_out, $is_active = true, $search;

    public $perPage = 10;
    public $loaded;
    public $lastId = null;
    public $hasMore = true;


    public $editMode = false;

    protected $resortManageService;

    protected $listeners = ['deleteItem'];

    public $images = [];
    public $removedImages = [];
    public $imageInputs = [0];

    public $packageTypes = [];


    public $factOptions = [];


    public $factOptionInputs = [0];



    use WithFileUploads;



    public function boot(ResortManageService $resortManageService)
    {
        $this->resortManageService = $resortManageService;
    }



    public function getRules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('resorts', 'name')->ignore($this->item->id ?? null),
            ],
            'distance' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'desc'     => 'required|string|max:255',
            'd_check_in'  => 'nullable',
            'd_check_out' => 'nullable',
            'n_check_in'  => 'nullable',
            'n_check_out' => 'nullable',
            'packageTypeId' => 'required|exists:resort_package_types,id',
            'is_active'  => 'boolean',
        ];
    }



    public function mount()
    {
        $this->packageTypes =  $this->resortManageService->getPackageTypes();
        $this->loaded = collect();
        $this->loadMore();
    }


    public function render()
    {
        return view('livewire.backend.manage-resort.manage-resort', [
            'infos' => $this->loaded
        ]);
    }





    /* reset input file */
    public function resetInputFields()
    {
        $this->item       = '';
        $this->itemId     = null;
        $this->name       = '';
        $this->distance   = '';
        $this->location   = '';
        $this->desc       = '';
        $this->d_check_in = '';
        $this->d_check_out = '';
        $this->n_check_in = '';
        $this->n_check_out = '';
        $this->images = [];
        $this->factOptions = [];
        $this->removedImages = [];
        $this->packageTypeId = null;
        $this->is_active = true;

        $this->search     = '';

        $this->resetErrorBag();
    }



    public function store()
    {
        $this->validate($this->getRules());

        $this->resortManageService->saveResortData([
            'name' => $this->name,
            'distance' => $this->distance,
            'location' => $this->location,
            'desc' => $this->desc,
            'd_check_in' => $this->d_check_in,
            'd_check_out' => $this->d_check_out,
            'n_check_in' => $this->n_check_in,
            'n_check_out' => $this->n_check_out,
            'packageTypeId' => $this->packageTypeId,
            'is_active' => $this->is_active,

        ]);

        $this->items =  $this->resortManageService->getAllResortData();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Resort saved Successfully!', 'success');
        $this->resetLoaded();
    }






    public function edit($id)
    {
        $this->editMode = true;
        $this->item = $this->resortManageService->getResortSingleData($id);

        if (!$this->item) {
            $this->toast('Resort not found!', 'error');
            return;
        }

        $this->name = $this->item->name;
        $this->distance = $this->item->distance;
        $this->location = $this->item->location;
        $this->desc = $this->item->desc;
        $this->d_check_in = $this->item->d_check_in;
        $this->d_check_out = $this->item->d_check_out;
        $this->n_check_in = $this->item->n_check_in;
        $this->n_check_out = $this->item->n_check_out;
        $this->packageTypeId = $this->item->package_id;
        $this->is_active = (bool) $this->item->is_active;
    }

    public function update()
    {
        $this->validate($this->getRules());


        if (!$this->item) {
            $this->toast('Resort not found!', 'error');
            return;
        }


        $this->resortManageService->updateResortSingleData($this->item, [
            'name'       => $this->name,
            'distance'       => $this->distance,
            'location'       => $this->location,
            'desc'       => $this->desc,
            'd_check_in'       => $this->d_check_in,
            'd_check_out'       => $this->d_check_out,
            'n_check_in'       => $this->n_check_in,
            'n_check_out'       => $this->n_check_out,
            'packageTypeId'       => $this->packageTypeId,
            'is_active'       => $this->is_active,

        ]);


        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Resort has been updated successfully!', 'success');
        $this->resetLoaded();
    }



    /* process while update */
    public function searchResort()
    {
        $this->resetLoaded();
    }




    // Load more function
    public function loadMore()
    {
        if (!$this->hasMore) return;

        $query = Resort::query();
        if ($this->search && $this->search != '') {
            $query->where('name', 'like', '%' . $this->search . '%');
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




    public function deleteItem($id)
    {
        $this->resortManageService->deleteResortData($id);



        $this->toast('Resort has been deleted!', 'success');
        $this->resetLoaded();
    }



    public function addResortImages($id)
    {
        $this->resetInputFields();
        $this->itemId = $id;

        $savedImages = $this->resortManageService->getResortImagesGallery($id);

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

        $this->resortManageService->saveResortImagesGallery($this->itemId, $this->images, $this->removedImages);



        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');


        $this->toast('Images saved successfully!', 'success');
        $this->resetLoaded();
    }





    public function manageFactOptions($id)
    {
        $this->resetInputFields();
        $this->itemId = $id;

        $savedOptions = $this->resortManageService->getFactOptions($id);

        $this->factOptions = $savedOptions->pluck('name')->toArray();


        $this->factOptionInputs = [];


        foreach ($this->factOptions as $key => $item) {
            $this->factOptionInputs[] = $key;
        }
        $this->factOptionInputs[] = count($this->factOptions);
    }




    public function addFactOptionInput()
    {
        $this->factOptionInputs[] = count($this->factOptionInputs);
    }

    public function removeFactOptionInput($index)
    {
        unset($this->factOptions[$index]);
        $this->factOptionInputs = array_values(array_diff($this->factOptionInputs, [$index]));
    }


    public function saveFactOptions()
    {

        $this->resortManageService->saveFactOptions($this->itemId, $this->factOptions);




        $this->editMode = false;


        $this->dispatch('closemodal');


        $this->toast('Additional facts saved successfully!', 'success');
        $this->resetLoaded();
    }


    public function toggleActive($id)
    {
        $item = $this->resortManageService->getResortSingleData($id);

        if (!$item) {
            $this->toast('Resort not found!', 'error');
            return;
        }

        $item->is_active = $item->is_active ? 0 : 1;
        $item->save();

        $this->items =  $this->resortManageService->getAllResortData();


        $this->toast('Status updated successfully!', 'success');
        $this->resetLoaded();
    }
}
