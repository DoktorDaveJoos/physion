<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Upsell;
use Illuminate\Http\Request;

class AddUpsellController extends Controller
{
    public function __invoke(Order $order, Upsell $upsell)
    {
        $order->upsells()->attach($upsell);

        return redirect()->route('checkout.show', $order->id);
    }
}
