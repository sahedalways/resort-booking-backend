<?php

namespace App\Livewire\Backend\Coupons;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\Coupon;
use App\Services\CouponManage\CouponManageService;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;


class ManageCoupons extends BaseComponent
{
    public $items, $item, $id, $code, $discount_value, $status = 'active', $search;


    public $editMode = false;
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;

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

        $this->items = new EloquentCollection();


        $this->loadCouponManageData();
    }


    public function render()
    {
        return view('livewire.backend.coupons.manage-coupons');
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



    /* process while update */
    public function updated()
    {
        $this->reloadCouponManageData();
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



        $this->refresh();
        $this->resetInputFields();
        $this->editMode = false;


        $this->dispatch('closemodal');
        $this->toast('Coupon has been updated successfully!', 'success');
    }



    /* process while update */
    public function searchCoupon()
    {
        if ($this->search != '') {
            $this->items = Coupon::where('code', 'like', '%' . $this->search)
                ->latest()
                ->get();
        } elseif ($this->search == '') {
            $this->items = new EloquentCollection();
        }

        $this->reloadCouponManageData();
    }



    /* refresh the page */
    public function refresh()
    {

        if ($this->search == '') {
            $this->items = $this->items->fresh();
        }
    }
    public function loadCouponManageData()
    {
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $list = $this->filterdata();
        $this->items->push(...$list->items());
        if ($this->hasMorePages = $list->hasMorePages()) {
            $this->nextCursor = $list->nextCursor()->encode();
        }
        $this->currentCursor = $list->cursor();
    }


    public function filterdata()
    {
        $query = Coupon::query();

        if ($this->search && $this->search != '') {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('code', 'like', $searchTerm);
            });
        }

        $data = $query->latest()
            ->cursorPaginate(10, ['*'], 'cursor', $this->nextCursor ? Cursor::fromEncoded($this->nextCursor) : null);

        return $data;
    }


    public function reloadCouponManageData()
    {
        $this->items = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        if ($this->hasMorePages !== null && !$this->hasMorePages) {
            return;
        }
        $data = $this->filterdata();
        $this->items->push(...$data->items());
        if ($this->hasMorePages = $data->hasMorePages()) {
            $this->nextCursor = $data->nextCursor()->encode();
        }
        $this->currentCursor = $data->cursor();
    }


    public function deleteItem($id)
    {
        $this->couponManage->deleteCouponManage($id);

        $this->reloadCouponManageData();

        $this->toast('Coupon has been deleted!', 'success');
    }
}
