<?php

namespace App\Livewire\Backend\ManageEvent;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\EventHero as EventHeroModel;
use App\Services\EventService;
use Livewire\WithFileUploads;

class EventHero extends BaseComponent
{
    use WithFileUploads;

    public $title, $sub_title, $hero_image, $phone_number, $old_hero_image;

    protected $rules = [
        'title'        => 'nullable|string|max:255',
        'sub_title'        => 'nullable|string|max:255',
        'hero_image'   => 'nullable|image|max:2096',
        'phone_number' => 'nullable|string|max:20',
    ];

    /* set value at the time of render */
    public function mount()
    {
        $hero = EventHeroModel::first();

        if ($hero) {
            $this->title = $hero->title;
            $this->sub_title = $hero->sub_title;
            $this->phone_number = $hero->phone_number;
            $this->old_hero_image = $hero->hero_url;
        }
    }

    /* save the Event Hero data */
    public function save(EventService $service)
    {
        $this->validate();

        $service->saveEventHeroSettings([
            'title'        => $this->title,
            'sub_title'        => $this->sub_title,
            'phone_number' => $this->phone_number,
            'hero_image'        => $this->hero_image,
        ]);

        $this->toast('Event Hero Updated Successfully!', 'success');
    }

    /* render the page */
    public function render()
    {
        return view('livewire.backend.manage-event.event-hero');
    }
}
