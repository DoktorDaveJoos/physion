<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class BedarfController extends Controller
{
    public function general(Request $request): \Inertia\Response
    {
        return Inertia::render('Bedarf/General', [
            'title' => 'Bedarfsausweis',
            'subtitle' => 'Allgemeine Informationen',
        ]);
    }

    public function cellar(Request $request): \Inertia\Response
    {
        return Inertia::render('Bedarf/Cellar', [
            'title' => 'Bedarfsausweis',
            'subtitle' => 'Keller',
        ]);
    }

    public function wall(Request $request): \Inertia\Response
    {
        return Inertia::render('Bedarf/Wall', [
            'title' => 'Bedarfsausweis',
            'subtitle' => 'Wände',
        ]);
    }

    public function window(Request $request): \Inertia\Response
    {
        return Inertia::render('Bedarf/Window', [
            'title' => 'Bedarfsausweis',
            'subtitle' => 'Fenster',
        ]);
    }

    public function roof(Request $request): \Inertia\Response
    {
        return Inertia::render('Bedarf/Roof', [
            'title' => 'Bedarfsausweis',
            'subtitle' => 'Dach',
        ]);
    }
}
