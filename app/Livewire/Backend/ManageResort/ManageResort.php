<?php

namespace App\Livewire\Backend\ManageResort;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\Resort;

use App\Services\ResortMange\ResortManageService;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;

class ManageResort extends BaseComponent
{
    public $items, $item, $itemId, $name, $distance, $location, $desc, $d_check_in, $d_check_out, $n_check_in, $n_check_out,   $search;


    public $editMode = false;
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;

    protected $resortManageService;

    protected $listeners = ['deleteItem'];



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
        ];
    }






    public function mount()
    {

        $this->items = new EloquentCollection();


        $this->loadResortData();
    }


    public function render()
    {
        return view('livewire.backend.manage-resort.manage-resort');
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

        ]);

        $this->items =  $this->resortManageService->getAllResortData();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Resort saved Successfully!', 'success');
    }



    /* process while update */
    public function updated()
    {
        $this->reloadResortData();
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

        ]);


        $this->refresh();
        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Resort has been updated successfully!', 'success');
    }



    /* process while update */
    public function searchResort()
    {
        if ($this->search != '') {
            $this->items = Resort::where('name', 'like', '%' . $this->search)
                ->latest()
                ->get();
        } elseif ($this->search == '') {
            $this->items = new EloquentCollection();
        }

        $this->reloadResortData();
    }



    /* refresh the page */
    public function refresh()
    {

        if ($this->search == '') {
            $this->items = $this->items->fresh();
        }
    }
    public function loadResortData()
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
        $query = Resort::query();

        if ($this->search && $this->search != '') {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm);
            });
        }

        $data = $query->latest()
            ->cursorPaginate(10, ['*'], 'cursor', $this->nextCursor ? Cursor::fromEncoded($this->nextCursor) : null);

        return $data;
    }


    public function reloadResortData()
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


    public function deleteItem($id)
    {
        $this->resortManageService->deleteResortData($id);

        $this->reloadResortData();

        $this->toast('Resort has been deleted!', 'success');
    }
}
