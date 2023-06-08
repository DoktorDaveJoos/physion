<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Upsell;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowController extends Controller
{
    /**
     * @param  Order  $order
     * @return Response
     */
    public function index(Order $order): Response
    {

        $order->load('products');



        return Inertia::render('Checkout/Index', [
            'order' => $order,
//            'addedUpsells' => $order->upsells,
//            'upsells' => Upsell::whereDoesntHave('orders', function ($query) use ($order) {
//                $query->where('order_id', $order->id);
//            })->get()
        ]);
    }


    public function thankyou(Order $order): Response
    {
        return Inertia::render('Checkout/ThankYou', [
            'order' => $order,
        ]);
    }
}
