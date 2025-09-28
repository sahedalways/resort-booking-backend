<?php

namespace App\Livewire\Backend\Settings;

use App\Livewire\Backend\Components\BaseComponent;
use App\Models\ContactInfoSettings as ContactInfoModel;
use App\Services\SettingService;

class ContactInfoSettings extends BaseComponent
{
    public $email, $phone, $dhaka_office_address, $gazipur_office_address;

    protected $rules = [
        'email'                => 'nullable|email|max:255',
        'phone'                => 'nullable|string|max:20',
        'dhaka_office_address'  => 'nullable|string|max:500',
        'gazipur_office_address' => 'nullable|string|max:500',
    ];

    /* render the page */
    public function render()
    {
        return view('livewire.backend.settings.contact-info-settings');
    }

    /* set value at the time of render */
    public function mount()
    {
        $settings = ContactInfoModel::first();

        if ($settings) {
            $this->email                 = $settings->email;
            $this->phone                 = $settings->phone;
            $this->dhaka_office_address  = $settings->dhaka_office_address;
            $this->gazipur_office_address = $settings->gazipur_office_address;
        }
    }

    /* save the Contact Info settings data */
    public function save(SettingService $service)
    {
        $this->validate();

        $service->saveContactInfoSettings([
            'email'                  => $this->email,
            'phone'                  => $this->phone,
            'dhaka_office_address'   => $this->dhaka_office_address,
            'gazipur_office_address' => $this->gazipur_office_address,
        ]);

        $this->toast('Contact Info Settings Updated Successfully!', 'success');
    }
}
