<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{

    public function index(): Response
    {
        return Inertia::render('Hub/Dashboard', [
            'activities' => [],
        ]);
    }


}
