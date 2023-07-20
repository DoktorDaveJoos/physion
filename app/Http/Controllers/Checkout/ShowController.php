<?php

namespace App\Http\Controllers\Checkout;

use App\Enums\Category;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Upsell;
use App\Notifications\OrderPaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
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

        $order->load('products', 'certificate');

        $order->update([
            'status' => 'finalized'
        ]);

        return Inertia::render('Checkout/Index', [
            'order' => $order,
            'addedUpsells' => $order->upsells,
            'upsells' => Product::whereDoesntHave('orders', function ($query) use ($order) {
                $query->where('order_id', $order->id);
            })->get()
        ]);
    }

    public function thankyou(Order $order): Response
    {

        $order->update([
            'status' => 'open'
        ]);

        $order->customer->notify(new OrderPaid($order, $order->customer->name));

        return Inertia::render('Checkout/ThankYou', [
            'link' => URL::temporarySignedRoute(
                'order.show',
                now()->addMinutes(30),
                ['order' => $order->slug]
            )
        ]);
    }
}
