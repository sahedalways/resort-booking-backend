<?php

namespace App\Livewire\Backend\ManageContent;

use App\Livewire\Backend\Components\BaseComponent;
use App\Services\ContentManageService;
use Livewire\WithFileUploads;


class FeaturesImages extends BaseComponent
{
    use WithFileUploads;

    public $resort_image;
    public $event_image;
    public $old_resort_image;
    public $old_event_image;
    protected ContentManageService $service;


    public function boot(ContentManageService $service)
    {
        $this->service = $service;
    }


    protected $rules = [
        'resort_image' => 'required|image|max:2048',
        'event_image'  => 'required|image|max:2048',
    ];


    public function mount()
    {
        $record = $this->service->getFeatureImages();

        $this->old_resort_image = $record->resortImageUrl;
        $this->old_event_image  = $record->eventImageUrl;
    }


    public function save()
    {
        $this->validate();

        $this->service->saveFeatureImages([
            'resort_image'        => $this->resort_image,
            'event_image' => $this->event_image,

        ]);


        $this->toast('Feature images updated successfully.', 'success');


        $this->mount();
    }

    public function render()
    {
        return view('livewire.backend.manage-content.features-images');
    }
}
