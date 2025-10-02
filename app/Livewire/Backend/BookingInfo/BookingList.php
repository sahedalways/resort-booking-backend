<?php

namespace App\Livewire\Backend\BookingInfo;

use App\Livewire\Backend\Components\BaseComponent;
use App\Services\BookingManageService;

class BookingList extends BaseComponent
{
  public $status;
  public $search;
  public $perPage = 10;
  public $loaded;
  public $lastId = null;
  public $hasMore = true;

  protected $BookingManage;
  protected $listeners = ['deleteItem'];

  public function boot(BookingManageService $BookingManage)
  {
    $this->BookingManage = $BookingManage;
  }

  public function mount($status = 'pending')
  {
    $this->status = $status;
    $this->loaded = collect();
    $this->loadMore();
  }

  public function render()
  {
    return view('livewire.backend.booking-info.booking-list', [
      'infos' => $this->loaded
    ]);
  }

  public function searchBooking()
  {
    $this->resetLoaded();
  }

  public function loadMore()
  {
    if (!$this->hasMore) return;

    $query = $this->BookingManage->searchBooking($this->search, $this->status);

    if ($this->lastId) {
      $query->where('id', '<', $this->lastId);
    }

    $items = $query->with(['user', 'resort', 'room'])
      ->orderBy('id', 'desc')
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

  private function resetLoaded()
  {
    $this->loaded = collect();
    $this->lastId = null;
    $this->hasMore = true;
    $this->loadMore();
  }

  public function deleteItem($id)
  {
    $this->BookingManage->deleteItem($id);
    $this->toast('Booking info has been deleted!', 'success');
    $this->resetLoaded();
  }



  public function confirmBooking($id)
  {
    $booking = $this->BookingManage->findBooking($id);

    if ($booking && $booking->status === 'pending') {
      $booking->status = 'confirmed';
      $booking->save();

      $this->toast('Booking has been confirmed!', 'success');


      return redirect()->route('admin.booking-info.confirm');
    }
  }
}
