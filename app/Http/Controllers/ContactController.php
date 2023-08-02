<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Support\Telegram\Telegram;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Contact/Index');
    }


    public function store(ContactRequest $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'nullable|string',
                'message' => 'required|string',
            ],
            [
                'name.required' => 'Bitte gib deinen Namen an.',
                'name.string' => 'Bitte gib einen gültigen Namen an.',
                'email.required' => 'Bitte gib deine E-Mail-Adresse an.',
                'email.email' => 'Bitte gib eine gültige E-Mail-Adresse an.',
                'phone.string' => 'Bitte gib eine gültige Telefonnummer an.',
                'message.required' => 'Bitte gib eine Nachricht an.',
                'message.string' => 'Bitte gib eine gültige Nachricht an.',
            ]
        );

        DB::insert('INSERT INTO contact_requests (name, email, phone, message) VALUES (?, ?, ?, ?)', [
            $request->validated('name'),
            $request->validated('email'),
            $request->validated('phone'),
            $request->validated('message'),
        ]);

        try {
            Telegram::broadcast('Neue Kontaktanfrage: '.$request->validated('name').', '.$request->validated('message'));
        } catch (Throwable $th) {
            Log::debug($th->getMessage());
            Telegram::broadcast('Neue Kontaktanfrage: '.$request->validated('name'));
        }

        return redirect()->route('contact.show');
    }
}
