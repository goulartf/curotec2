<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{

    public function index()
    {
        return Contact::latest()->get();
    }

    public function store(Request $request)
    {
        return Contact::create($request->only('name', 'email', 'phone'));
    }

    public function update(Request $request, Contact $contact)
    {
        return $contact->update($request->only('name', 'email', 'phone'));
    }

    public function destroy(Contact $contact)
    {
        return $contact->delete();
    }
}
