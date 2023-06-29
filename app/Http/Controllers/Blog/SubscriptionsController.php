<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionsController extends Controller
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

        return redirect()->back();
    }
}
