<?php

namespace App\Livewire\Backend\Reviews;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\Review;
use App\Services\ReviewManageService;


class Reviews extends BaseComponent
{
    public $search;


    public $editMode = false;
    public $perPage = 10;
    public $loaded;
    public $lastId = null;
    public $hasMore = true;

    protected $manageReviewService;

    protected $listeners = ['deleteReview'];


    public function boot(ReviewManageService $manageReviewService)
    {
        $this->manageReviewService = $manageReviewService;
    }



    public function mount()
    {

        $this->loaded = collect();
        $this->loadMore();
    }


    public function render()
    {
        return view('livewire.backend.reviews.reviews', [
            'infos' => $this->loaded
        ]);
    }



    /* process while update */
    public function searchReview()
    {
        $this->resetLoaded();
    }




    // Load more function
    public function loadMore()
    {
        if (!$this->hasMore) return;

        $query = Review::query();

        if ($this->search && $this->search != '') {
            $search = $this->search;

            $query->where(function ($q) use ($search) {

                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('f_name', 'like', '%' . $search . '%');
                    $q2->where('email', 'like', '%' . $search . '%')
                        ->orWhere('l_name', 'like', '%' . $search . '%');
                });


                $q->orWhereHas('resort', function ($q3) use ($search) {
                    $q3->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        if ($this->lastId) {
            $query->where('id', '<', $this->lastId);
        }

        $items = $query->with(['user', 'resort'])
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



    public function deleteReview($id)
    {
        $this->manageReviewService->deleteReview($id);


        $this->toast('Review has been deleted!', 'success');
        $this->resetLoaded();
    }
}
