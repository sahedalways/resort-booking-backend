<?php

namespace App\Livewire\Backend\Coupons;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\Coupon;
use App\Services\CouponManage\CouponManageService;
use Illuminate\Validation\Rule;



class ManageCoupons extends BaseComponent
{
    public $items, $item, $id, $code, $discount_value, $status = 'active', $search;
    public $perPage = 10;
    public $loaded;
    public $lastId = null;
    public $hasMore = true;

    public $editMode = false;


    protected $couponManage;

    protected $listeners = ['deleteItem'];


    public function boot(CouponManageService $couponManage)
    {
        $this->couponManage = $couponManage;
    }

    public function getRules()
    {
        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons', 'code')->ignore($this->item->id ?? null),
            ],
            'discount_value' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ];
    }



    public function mount()
    {
        $this->loaded = collect();
        $this->loadMore();
    }

    public function render()
    {
        return view('livewire.backend.coupons.manage-coupons', [
            'infos' => $this->loaded
        ]);
    }


    /* reset input file */
    public function resetInputFields()
    {
        $this->item = '';
        $this->code = '';
        $this->discount_value = '';
        $this->status = 'active';
        $this->resetErrorBag();
    }


    /* store event service data */
    public function store()
    {
        $this->validate($this->getRules());

        $this->couponManage->saveCouponManage([
            'discount_value' => $this->discount_value,
            'code'  => $this->code,
            'status'  => $this->status,
        ]);

        $this->items =  $this->couponManage->getAllCouponManageData();

        $this->resetInputFields();
        $this->dispatch('closemodal');

        $this->toast('Coupon saved Successfully!', 'success');

        $this->resetLoaded();
    }



    public function edit($id)
    {
        $this->editMode = true;
        $this->item = $this->couponManage->getSingleCoupon($id);

        if (!$this->item) {
            $this->toast('Coupon not found!', 'error');
            return;
        }

        $this->discount_value = $this->item->discount_value;
        $this->code = $this->item->code;
        $this->status = $this->item->status;
    }


    public function update()
    {
        $this->validate($this->getRules());


        if (!$this->item) {
            $this->toast('Coupon not found!', 'error');
            return;
        }

        $this->couponManage->updateCouponManageSingleData($this->item, [
            'discount_value'       => $this->discount_value,
            'code' => $this->code,
            'status' => $this->status,
        ]);


        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Coupon has been updated successfully!', 'success');

        $this->resetLoaded();
    }



    /* process while update */
    public function searchCoupon()
    {

        $this->resetLoaded();
    }



    // Load more function
    public function loadMore()
    {
        if (!$this->hasMore) return;

        $query = Coupon::query();
        if ($this->search && $this->search != '') {
            $query->where('code', 'like', '%' . $this->search . '%');
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





    public function deleteItem($id)
    {
        $this->couponManage->deleteCouponManage($id);


        $this->toast('Coupon has been deleted!', 'success');

        $this->resetLoaded();
    }
}
