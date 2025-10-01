<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\API\BaseController;
use App\Models\Resort;

class ResortController extends BaseController
{
    public function show($id)
    {
        $resort = Resort::with(['images', 'additionalFacts', 'packageType', 'facilities', 'facilities.facility'])->findOrFail($id);


        return view('livewire.backend.manage-resort.show', compact('resort'));
    }
}
