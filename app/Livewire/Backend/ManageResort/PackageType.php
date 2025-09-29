<?php

namespace App\Livewire\Backend\ManageResort;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\ResortPackageType;
use App\Services\ResortMange\PackageTypeManageService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;


class PackageType extends BaseComponent
{
    public $pt_infos, $pt_item, $pt_id, $type_name, $icon, $old_icon, $is_refundable,  $search;


    public $editMode = false;
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;

    protected $resortPT;

    protected $listeners = ['deletePT'];


    public function boot(PackageTypeManageService $resortPT)
    {
        $this->resortPT = $resortPT;
    }


    protected $rules = [
        'type_name' => 'required|string|max:255',
        'icon' => 'required|string|max:255',
        'is_refundable' => 'required|boolean',
    ];



    public function mount()
    {

        $this->pt_infos = new EloquentCollection();


        $this->loadResortPtData();
    }


    public function render()
    {
        return view('livewire.backend.manage-resort.package-type');
    }


    /* reset input file */
    public function resetInputFields()
    {
        $this->pt_item = '';
        $this->icon = '';
        $this->type_name = '';
        $this->old_icon = '';
        $this->is_refundable;
        $this->resetErrorBag();
    }


    /* store event service data */
    public function store()
    {
        $this->validate();

        $this->resortPT->saveResortPT([
            'type_name' => $this->type_name,
            'icon'  => $this->icon,
            'is_refundable'  => $this->is_refundable,
        ]);

        $this->pt_infos =  $this->resortPT->getAllResortPTData();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Package Type saved Successfully!', 'success');
    }



    /* process while update */
    public function updated()
    {
        $this->reloadResortPtData();
    }



    public function edit($id)
    {
        $this->editMode = true;
        $this->pt_item = $this->resortPT->getPTSingleData($id);

        if (!$this->pt_item) {
            $this->toast('Package Type not found!', 'error');
            return;
        }

        $this->type_name = $this->pt_item->type_name;
        $this->icon = $this->pt_item->icon;
        $this->old_icon = $this->pt_item->icon;
        $this->is_refundable = $this->pt_item->is_refundable;
    }

    public function update()
    {
        $this->validate();

        if (!$this->pt_item) {
            $this->toast('Package Type not found!', 'error');
            return;
        }


        $this->resortPT->updateResortPTSingleData($this->pt_item, [
            'type_name'       => $this->type_name,
            'icon' => $this->icon,
            'is_refundable' => $this->is_refundable,
        ]);


        $this->refresh();
        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Package Type has been updated successfully!', 'success');
    }



    /* process while update */
    public function searchPT()
    {
        if ($this->search != '') {
            $this->pt_infos = ResortPackageType::where('type_name', 'like', '%' . $this->search)
                ->latest()
                ->get();
        } elseif ($this->search == '') {
            $this->pt_infos = new EloquentCollection();
        }

        $this->reloadResortPtData();
    }



    /* refresh the page */
    public function refresh()
    {

        if ($this->search == '') {
            $this->pt_infos = $this->pt_infos->fresh();
        }
    }
    public function loadResortPtData()
    {
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $ptList = $this->filterdata();
        $this->pt_infos->push(...$ptList->items());
        if ($this->hasMorePages = $ptList->hasMorePages()) {
            $this->nextCursor = $ptList->nextCursor()->encode();
        }
        $this->currentCursor = $ptList->cursor();
    }


    public function filterdata()
    {
        $query = ResortPackageType::query();

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


    public function reloadResortPtData()
    {
        $this->pt_infos = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $data = $this->filterdata();
        $this->pt_infos->push(...$data->items());
        if ($this->hasMorePages = $data->hasMorePages()) {
            $this->nextCursor = $data->nextCursor()->encode();
        }
        $this->currentCursor = $data->cursor();
    }


    public function deletePT($id)
    {
        $this->resortPT->deleteResortPT($id);

        $this->reloadResortPtData();

        $this->toast('Package Type has been deleted!', 'success');
    }
}
