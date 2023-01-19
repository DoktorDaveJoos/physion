<?php

namespace App\Http\Controllers\Bedarf;

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

        if (!$order->isBedarf()) {
            abort(404);
        }

        return Inertia::render('Bedarf/General', [
            'title' => 'Bedarfsausweis',
            'subtitle' => 'Allgemeine Informationen',
            'step' => 'general',
            'context' => 'bedarf',
            'order' => $order,
            'product' => $order->product,
            'customer' => $order->customer,
        ]);
    }

    public function wall(Order $order): Response
    {
        if (!$order->isBedarf()) {
            abort(404);
        }

        return Inertia::render('Bedarf/Wall', [
            'title' => 'Bedarfsausweis',
            'subtitle' => 'Allgemeine Informationen',
            'step' => 'wall',
            'context' => 'bedarf',
            'order' => $order,
            'product' => $order->product,
            'customer' => $order->customer,
        ]);
    }

}
