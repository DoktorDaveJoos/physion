<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function __invoke(Request $request)
    {
        return Inertia::render('Hub/Dashboard', [
            'products' => Product::where('recurring', true)->where('type', 'certificate')->get(),
            'stats' => [
                'orders' => [
                    'open' => Order::where('status', 'open')->where(
                        'team_id',
                        $request->user()?->current_team_id
                    )->count(),
                    'all' => Order::where('team_id', $request->user()->current_team_id)->count(),
                ],
                'team' => [
                    'members' => $request->user()->currentTeam?->allUsers()?->count(),
                ],
                'subscription' => $request->user()->currentTeam?->subscribed('default'),
            ],
        ]);
    }


}
