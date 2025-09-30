<?php

namespace App\Livewire\Backend\ManageResort;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\Resort;
use App\Models\ResortFacilityOptionService;
use App\Models\ResortRoomFacility;
use App\Services\ResortMange\ResortManageService;
use Illuminate\Validation\Rule;

class ManageResortFacilities extends BaseComponent
{
    public $resort, $service_name, $icon, $search;
    public $facilities;

    public $serviceInfos = [];

    public $selectedFacilityId;
    public $selectedFacility;

    protected $resortManageService;


    public function boot(ResortManageService $resortManageService)
    {
        $this->resortManageService = $resortManageService;
    }


    public function mount(Resort $resort)
    {
        $this->resort = $resort->load(['facilities', 'facilities.facility']);


        $this->facilities = $this->resortManageService->getResortFacilitiesData();
    }

    public function render()
    {
        return view('livewire.backend.manage-resort.manage-resort-facilities');
    }


    public function getRules()
    {
        return [
            'selectedFacilityId' => [
                'required',
                Rule::unique('resort_facility_option_services', 'facility_id')
                    ->where(fn($query) => $query->where('resort_id', $this->resort->id)),
            ],

        ];
    }

    public function getMessages()
    {
        return [
            'selectedFacilityId.unique' => 'The selected facility has already been taken.',

        ];
    }





    /* reset input file */
    public function resetInputFields()
    {
        $this->search     = '';
        $this->selectedFacilityId     = null;
        $this->selectedFacility     = null;
        $this->service_name     = '';
        $this->icon     = '';
        $this->serviceInfos     = [];

        $this->resetErrorBag();
    }




    public function loadFacilityServices()
    {
        if ($this->selectedFacilityId) {
            $this->selectedFacility = ResortRoomFacility::with('options.service')
                ->find($this->selectedFacilityId);



            if ($this->selectedFacility) {
                $this->serviceInfos = $this->selectedFacility->options->map(function ($option) {
                    return [
                        'type_name' => $option->service?->type_name ?? '',
                        'icon'      => $option->service?->icon ?? '',
                    ];
                })->toArray();
            } else {
                $this->serviceInfos = [];
            }
        } else {
            $this->selectedFacility = null;
            $this->serviceInfos = [];
        }
    }

    public function addService()
    {

        $this->serviceInfos[] = [
            'type_name' => '',
            'icon' => '',
        ];
    }

    public function removeService($index)
    {
        unset($this->serviceInfos[$index]);
        $this->serviceInfos = array_values($this->serviceInfos);
    }




    public function store()
    {
        $this->validate($this->getRules());

        if (!$this->resort) {
            $this->toast('Resort not found!', 'error');
            return;
        }


        $this->resortManageService->saveResortsFacility($this->serviceInfos, $this->selectedFacilityId, $this->resort->id);


        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Resort facility and services saved successfully!', 'success');
    }


    public function deleteService($facilityId, $serviceName)
    {

        $this->resortManageService->deleteServiceItem($this->resort->id, $facilityId, $serviceName);


        $this->toast('Service deleted successfully!', 'success');
    }


    public function addNewService($facilityId)
    {
        $this->resetInputFields();


        $this->selectedFacilityId = $facilityId;
    }


    public function saveService()
    {
        $this->validate([
            'service_name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ], [
            'service_name.required' => 'The service name is required.',
            'icon.required' => 'The icon is required.',
        ]);

        if (!$this->resort) {
            $this->toast('Resort not found!', 'error');
            return;
        }

        if (!$this->selectedFacilityId) {
            $this->toast('Facility ID not found!', 'error');
            return;
        }


        $this->resortManageService->saveServiceName($this->resort->id, $this->selectedFacilityId, $this->service_name, $this->icon);


        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Service name saved successfully!', 'success');
    }



    public function searchFacility()
    {



        $query = $this->search;

        if ($query) {

            $filtered = $this->resort->facilities->filter(function ($facility) use ($query) {
                return str_contains(strtolower($facility->facility->name), strtolower($query));
            })->values();


            $this->resort->setRelation('facilities', $filtered);
        }
    }
}
