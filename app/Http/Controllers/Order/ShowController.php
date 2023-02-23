<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class ShowController extends Controller
{
    /**
     * @param  Order  $order
     * @return RedirectResponse|Response
     */
    public function index(Order $order): RedirectResponse|Response
    {

        if ($order->isDone()) {
            $order->load('upsells');
            return Inertia::render('Order/Index', [
                'order' => $order,
                'product' => $order->product,
            ]);
        }

        if ($order->isBedarf()) {
            return Redirect::route('bedarf.general', ['order' => $order]);
        }

        if ($order->isVerbrauch()) {
            return Redirect::route('verbrauch.general', ['order' => $order]);
        }

        throw new RuntimeException('Order type not found.');
    }
}
