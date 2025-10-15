<?php

namespace App\Livewire\Backend;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\EventContact;

class EventContactInfo extends BaseComponent
{
    public $search;
    public $perPage = 10;
    public $loaded;
    public $lastId = null;
    public $hasMore = true;

    public $editMode = false;
    public $contactId;
    public $name;
    public $phone;
    public $date_of_function;
    public $gathering_size;
    public $preferred_location;
    public $budget;
    public $message;

    public function mount()
    {
        $this->loaded = collect();
        $this->loadMore();
    }

    public function render()
    {
        return view('livewire.backend.event-contact-info', [
            'infos' => $this->loaded
        ]);
    }

    // Search contacts
    public function searchContact()
    {
        $this->resetLoaded();
    }

    // Load more function
    public function loadMore()
    {
        if (!$this->hasMore) return;

        $query = EventContact::query();

        if ($this->search && $this->search != '') {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
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

            EventContact::whereIn('id', $items->pluck('id'))->update(['is_read' => true]);
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
}
