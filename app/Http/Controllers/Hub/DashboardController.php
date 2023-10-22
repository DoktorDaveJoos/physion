<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        return Inertia::render('Hub/Dashboard', [
            'activities' => [],
            'products' => Product::where('recurring', true)->where('type', 'certificate')->get(),
            'stats' => [
                'team' => [
                    'members' => $request->user()->currentTeam?->allUsers()?->count(),
                ],
                'subscription' => $request->user()->currentTeam?->subscribed('default'),
            ],
        ]);
    }


}
