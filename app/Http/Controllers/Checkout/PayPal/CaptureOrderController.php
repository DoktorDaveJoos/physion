<?php

namespace App\Http\Controllers\Checkout\PayPal;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CaptureOrderController extends Controller
{

    public function __invoke(Order $order)
    {
        $order->capture();
        return redirect()->route('checkout.thankyou', $order);
    }
}
