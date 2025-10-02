<?php

namespace App\Livewire\Backend\Payments;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\Payment;
use App\Services\PaymentManageService;

class Payments extends BaseComponent
{
    public $search;


    public $editMode = false;
    public $perPage = 10;
    public $loaded;
    public $lastId = null;
    public $hasMore = true;

    protected $managePaymentService;

    protected $listeners = ['deletePaymentItem'];


    public function boot(PaymentManageService $managePaymentService)
    {
        $this->managePaymentService = $managePaymentService;
    }



    public function mount()
    {

        $this->loaded = collect();
        $this->loadMore();
    }


    public function render()
    {
        return view('livewire.backend.payments.payments', [
            'infos' => $this->loaded
        ]);
    }



    /* process while update */
    public function searchBT()
    {
        $this->resetLoaded();
    }




    // Load more function
    public function loadMore()
    {
        if (!$this->hasMore) return;

        $query = Payment::query();

        if ($this->search && $this->search != '') {
            $search = $this->search;

            $query->where(function ($q) use ($search) {

                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('f_name', 'like', '%' . $search . '%')
                        ->orWhere('l_name', 'like', '%' . $search . '%');
                });


                $q->orWhereHas('booking.resort', function ($q3) use ($search) {
                    $q3->where('name', 'like', '%' . $search . '%');
                });


                $q->orWhere('transaction_id', 'like', '%' . $search . '%');
            });
        }

        if ($this->lastId) {
            $query->where('id', '<', $this->lastId);
        }

        $items = $query->with(['user', 'booking.resort', 'booking.resort.rooms'])
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



    // Reset loaded collection
    private function resetLoaded()
    {
        $this->loaded = collect();
        $this->lastId = null;
        $this->hasMore = true;
        $this->loadMore();
    }



    public function deletePaymentItem($id)
    {
        $this->managePaymentService->deletePaymentItem($id);


        $this->toast('Payment item has been deleted!', 'success');
        $this->resetLoaded();
    }
}
