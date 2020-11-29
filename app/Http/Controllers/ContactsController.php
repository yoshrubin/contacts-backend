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

        return $contact;
    }

    public function list()
    {
        return Contact::paginate(20);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30',
            'phone' => 'required|string|max:15',
            'title' => 'required|string|max:10',
            'avatar' => 'required|string|max:50'
        ]);

        $contact = Contact::findOrFail($id);

        $contact->name = $validated['name'];
        $contact->phone = $validated['phone'];
        $contact->title = $validated['title'];
        $contact->avatar = $validated['avatar'];

        $contact->save();

        return $contact;
    }

    public function delete($id)
    {
        $contact = Contact::findOrFail($id);

        return $contact->delete();
    }
}
