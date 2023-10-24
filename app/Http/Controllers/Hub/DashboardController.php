<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function index()
    {
        return Inertia::render('Hub/Dashboard', [
            'activities' => [],
        ]);
    }


}
