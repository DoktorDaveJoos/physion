<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Support\Telegram\Telegram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscriptions,email',
        ], [
            'email.required' => 'Bitte gib eine E-Mail-Adresse an.',
            'email.email' => 'Bitte gib eine gültige E-Mail-Adresse an.',
            'email.unique' => 'Diese E-Mail-Adresse ist bereits abonniert.',
        ]);

        DB::insert('insert into newsletter_subscriptions (email, created_at, updated_at) values (?, ?, ?)', [
            $request->input('email'),
            now(),
            now(),
        ]);

        Telegram::broadcast('Neue Newsletter-Anmeldung: '.$request->input('email'));

        return redirect()->back();
    }

    public function storeBusiness(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:partner_requests,email',
        ], [
            'email.required' => 'Bitte gib eine E-Mail-Adresse an.',
            'email.email' => 'Bitte gib eine gültige E-Mail-Adresse an.',
            'email.unique' => 'Diese E-Mail-Adresse wurde bereits eingegeben.',
        ]);

        DB::insert('insert into partner_requests (email, created_at, updated_at) values (?, ?, ?)', [
            $request->input('email'),
            now(),
            now(),
        ]);

        Telegram::broadcast('Ein interessierter Partner: '.$request->input('email'));

        return redirect()->back();
    }
}
