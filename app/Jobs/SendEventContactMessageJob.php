<?php

namespace App\Jobs;

use App\Models\EventContact;
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
    protected bool $isEvent;
    public function __construct(EventContact $contact, bool $isEvent = false)
    {
        $this->contact = $contact;
        $this->isEvent = $isEvent;
    }
    public function handle(): void
    {

        $supportEmail = $this->isEvent
            ? getEventContactMail()
            : getSiteEmail();

        if (!$supportEmail) return;

        $subject = $this->isEvent
            ? 'New Event Contact Message Received'
            : 'New Contact Message Received';

        Mail::send('mail.eventContactMessage', [
            'contact' => $this->contact,
            'isEvent' => $this->isEvent,
        ], function ($message) use ($supportEmail, $subject) {
            $message->to($supportEmail)
                ->subject($subject);
        });
    }
}
