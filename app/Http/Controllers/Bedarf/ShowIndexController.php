<?php

namespace App\Http\Controllers\Bedarf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowIndexController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Bedarf/Index', [
            'title' => 'Bedarfsausweis',
            'subtitle' => 'Anlegen',
            'step' => 'general'
        ]);
    }
}
