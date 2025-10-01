<?php

namespace App\Livewire\Backend\Coupons;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\Coupon;
use App\Services\CouponManage\CouponManageService;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;
use Livewire\WithPagination;


class ManageCoupons extends BaseComponent
{
    public $items, $item, $id, $code, $discount_value, $status = 'active', $search;
    use WithPagination;

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



    public function render()
    {
        $infos = $this->filterData();

        return view('livewire.backend.coupons.manage-coupons', [
            'infos' => $infos
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
    }



    /* process while update */
    public function searchCoupon()
    {
        $this->resetPage();
    }


    public function filterData()
    {
        $query = Coupon::query();

        if ($this->search && $this->search != '') {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('code', 'like', $searchTerm);
            });
        }

        return $query->latest()->paginate(10);
    }




    public function deleteItem($id)
    {
        $this->couponManage->deleteCouponManage($id);


        $this->toast('Coupon has been deleted!', 'success');
    }
}
