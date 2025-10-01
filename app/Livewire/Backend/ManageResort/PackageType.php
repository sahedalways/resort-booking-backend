<?php

namespace App\Livewire\Backend\ManageResort;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\ResortPackageType;
use App\Services\ResortMange\PackageTypeManageService;
use Livewire\WithPagination;


class PackageType extends BaseComponent
{
    public $pt_infos, $pt_item, $pt_id, $type_name, $icon, $old_icon, $is_refundable = true,  $search;

    use WithPagination;
    public $editMode = false;

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



    public function render()
    {
        $infos = $this->filterData();

        return view('livewire.backend.manage-resort.package-type', [
            'infos' => $infos
        ]);
    }


    /* reset input file */
    public function resetInputFields()
    {
        $this->pt_item = '';
        $this->icon = '';
        $this->type_name = '';
        $this->old_icon = '';
        $this->is_refundable = true;
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
        $this->resetPage();
    }



    /* refresh the page */
    public function refresh()
    {

        if ($this->search == '') {
            $this->pt_infos = $this->pt_infos->fresh();
        }
    }



    public function filterData()
    {
        $query = ResortPackageType::query();

        if ($this->search && $this->search != '') {
            $searchTerm = '%' . $this->search . '%';
            $query->where('type_name', 'like', $searchTerm);
        }


        return $query->latest()->paginate(10);
    }





    public function deletePT($id)
    {
        $this->resortPT->deleteResortPT($id);

        $this->toast('Package Type has been deleted!', 'success');
    }
}
