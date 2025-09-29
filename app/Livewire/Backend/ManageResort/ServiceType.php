<?php

namespace App\Livewire\Backend\ManageResort;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\ResortServiceType;
use App\Services\ResortMange\ServiceTypeManageService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;


class ServiceType extends BaseComponent
{
    public $st_infos, $st_item, $st_id, $type_name, $icon, $old_icon, $search;


    public $editMode = false;
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;

    protected $resortST;

    protected $listeners = ['deleteST'];


    public function boot(ServiceTypeManageService $resortST)
    {
        $this->resortST = $resortST;
    }


    protected $rules = [
        'type_name' => 'required|string|max:255',
        'icon' => 'required|string|max:255',
    ];



    public function mount()
    {

        $this->st_infos = new EloquentCollection();


        $this->loadResortStData();
    }


    public function render()
    {
        return view('livewire.backend.manage-resort.service-type');
    }


    /* reset input file */
    public function resetInputFields()
    {
        $this->st_item = '';
        $this->icon = '';
        $this->type_name = '';
        $this->old_icon = '';
        $this->resetErrorBag();
    }


    /* store event service data */
    public function store()
    {
        $this->validate();

        $this->resortST->saveResortST([
            'type_name' => $this->type_name,
            'icon'  => $this->icon,
        ]);

        $this->st_infos =  $this->resortST->getAllResortSTData();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Service Type saved Successfully!', 'success');
    }



    /* process while update */
    public function updated()
    {
        $this->reloadResortStData();
    }



    public function edit($id)
    {
        $this->editMode = true;
        $this->st_item = $this->resortST->getSTSingleData($id);

        if (!$this->st_item) {
            $this->toast('Service type not found!', 'error');
            return;
        }

        $this->type_name = $this->st_item->type_name;
        $this->icon = $this->st_item->icon;
        $this->old_icon = $this->st_item->icon;
    }

    public function update()
    {
        $this->validate([
            'type_name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);


        if (!$this->st_item) {
            $this->toast('Service type not found!', 'error');
            return;
        }


        $this->resortST->updateResortSTSingleData($this->st_item, [
            'type_name'       => $this->type_name,
            'icon' => $this->icon,
        ]);


        $this->refresh();
        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Service type has been updated successfully!', 'success');
    }



    /* process while update */
    public function searchST()
    {
        if ($this->search != '') {
            $this->st_infos = ResortServiceType::where('type_name', 'like', '%' . $this->search)
                ->latest()
                ->get();
        } elseif ($this->search == '') {
            $this->st_infos = new EloquentCollection();
        }

        $this->reloadResortStData();
    }



    /* refresh the page */
    public function refresh()
    {

        if ($this->search == '') {
            $this->st_infos = $this->st_infos->fresh();
        }
    }
    public function loadResortStData()
    {
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $stList = $this->filterdata();
        $this->st_infos->push(...$stList->items());
        if ($this->hasMorePages = $stList->hasMorePages()) {
            $this->nextCursor = $stList->nextCursor()->encode();
        }
        $this->currentCursor = $stList->cursor();
    }


    public function filterdata()
    {
        $query = ResortServiceType::query();

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


    public function reloadResortStData()
    {
        $this->st_infos = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $data = $this->filterdata();
        $this->st_infos->push(...$data->items());
        if ($this->hasMorePages = $data->hasMorePages()) {
            $this->nextCursor = $data->nextCursor()->encode();
        }
        $this->currentCursor = $data->cursor();
    }


    public function deleteST($id)
    {
        $this->resortST->deleteResortST($id);

        $this->reloadResortStData();

        $this->toast('Service type has been deleted!', 'success');
    }
}
