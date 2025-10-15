<?php

namespace App\Jobs;

use App\Models\EventContact;
use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEventContactMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected EventContact $contact;

    public function __construct(EventContact $contact)
    {
        $this->contact = $contact;
    }

    public function handle(): void
    {
        // Get support email from site settings
        $supportEmail = SiteSetting::value('site_email');
        if (!$supportEmail) return;

        Mail::send('mail.eventContactMessage', [
            'contact' => $this->contact,
        ], function ($message) use ($supportEmail) {
            $message->to($supportEmail)
                ->subject('New Event Contact Message Received');
        });
    }
}
