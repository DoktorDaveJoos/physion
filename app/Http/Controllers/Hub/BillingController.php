<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillingController extends Controller
{

    public function __invoke(Request $request)
    {
        $team = $request->user()->currentTeam;
        $team->createOrGetStripeCustomer();

        return $team->redirectToBillingPortal(route('hub.dashboard'));
    }

}
