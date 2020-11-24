<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use App\Models\Contact;


class ContactsController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30',
            'phone' => 'required|string|max:15',
            'title' => 'required|string|max:10',
            'avatar' => 'required|string|max:50'
        ]);

        return Contact::create(
            $validated
        );
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        return ContactResource::make($contact);
    }

    public function list(Request $request)
    {
        $perPage = 10;

        $contact = new Contact();

        if ($perPage === 'all') {
            $perPage = $contact->count();
        }

        return ContactResource::collection($contact->pagination($perPage));
    }
}
