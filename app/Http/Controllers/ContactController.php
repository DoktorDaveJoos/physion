<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Contact/Index');
    }


    public function store(ContactRequest $request)
    {
        DB::insert('INSERT INTO contact_requests (name, email, phone, message) VALUES (?, ?, ?, ?)', [
            $request->input('name'),
            $request->input('email'),
            $request->input('phone'),
            $request->input('message'),
        ]);

        return redirect()->route('contact.show')->with('success', 'Your message has been sent.');
    }
}
