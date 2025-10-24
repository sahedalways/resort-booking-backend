<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ContactRequest;
use App\Jobs\SendEventContactMessageJob;
use App\Models\EventContact;

class ContactController extends BaseController
{

    public function store(ContactRequest $request)
    {
        $validated = $request->validated();

        // Save to database
        $contact = EventContact::create($validated);


        if ($contact) {
            SendEventContactMessageJob::dispatch($contact);
        }

        return response()->json([
            'success' => true,
            'message' => 'Contact message sent successfully!',
            'data' => $contact,
        ]);
    }
}
