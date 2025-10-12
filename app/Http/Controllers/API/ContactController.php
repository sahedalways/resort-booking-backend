<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;


class ContactController extends BaseController
{

    public function store(ContactRequest $request)
    {
        $validated = $request->validated();

        // Save to database
        $contact = Contact::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Contact message sent successfully!',
            'data' => $contact,
        ]);
    }
}
