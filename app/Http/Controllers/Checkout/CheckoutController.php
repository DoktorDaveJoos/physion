<?php

declare(strict_types=1);

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use Throwable;

class CheckoutController extends Controller
{
    /**
     */
    public function __construct(public StripeClient $client)
    {
    }

    /**
     * @throws ApiErrorException
     * @throws Throwable
     */
    public function checkoutSession(Order $order, Request $request): RedirectResponse
    {
        $lineItems = $order->products()->get()->map(function ($product) {
            return [
                'price' => $this->client->products->retrieve($product->stripe_product_id)->default_price,
                'quantity' => 1,
            ];
        })->toArray();

        $checkout_session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['order' => $order->slug]),
            'cancel_url' => route('checkout.show', ['order' => $order->slug, 'signature' => $request->get('signature')]),
            'customer' => $order->customer->stripe_customer_id,
            'billing_address_collection' => 'auto',
            'shipping_address_collection' => [
                'allowed_countries' => ['DE', 'AT', 'CH'],
            ],
            'customer_update' => [
                'shipping' => 'auto'
            ],
            'automatic_tax' => [
                'enabled' => true,
            ],
            'client_reference_id' => $order->id,
        ]);
        ray($checkout_session->url);

        return Redirect::away($checkout_session->url);
    }


}
