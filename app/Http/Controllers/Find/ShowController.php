<?php

namespace App\Http\Controllers\Find;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowController extends Controller
{

    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Find/Index', [
            'results' => Order::all(),
        ]);
    }

}
