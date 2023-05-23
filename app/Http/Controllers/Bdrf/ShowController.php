<?php

namespace App\Http\Controllers\Bdrf;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Order  $order
     * @return Response
     */
    public function index(Order $order): Response
    {
        return Inertia::render('Bedarf/General', [
            'step' => 'general',
            'context' => 'bedarf',
            'order' => $order->load('product', 'customer'),
        ]);
    }

    public function details(Order $order): Response
    {

        return Inertia::render('Bedarf/Details', [
            'step' => 'details',
            'context' => 'bedarf',
            'order' => $order->load('product', 'customer'),
        ]);
    }

    public function position(Order $order): Response
    {

        return Inertia::render('Bedarf/Position', [
            'title' => 'Bedarfsausweis',
            'step' => 'position',
            'context' => 'bedarf',
            'order' => $order,
            'product' => $order->product,
            'customer' => $order->customer,
        ]);
    }

    public function wall(Order $order): Response
    {

        $order->product->load('roof', 'wall', 'roof.windows', 'roof.dormers', 'roof.insulations');

        return Inertia::render('Bedarf/Wall', [
            'title' => 'Bedarfsausweis',
            'subtitle' => 'Allgemeine Informationen',
            'step' => 'wall',
            'context' => 'bedarf',
            'order' => $order,
        ]);
    }

}
