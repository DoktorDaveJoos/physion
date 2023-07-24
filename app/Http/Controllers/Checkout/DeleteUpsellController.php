<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Upsell;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeleteUpsellController extends Controller
{
    /**
     * @param  Order  $order
     * @param  Upsell  $upsell
     * @return RedirectResponse
     */
    public function __invoke(Order $order, Product $upsell, Request $request): RedirectResponse
    {
        $order->upsells()->detach($upsell);

        return redirect()->route('checkout.show', [
            'order' => $order->slug,
            'signature' => $request->get('signature'),
        ]);
    }

}
