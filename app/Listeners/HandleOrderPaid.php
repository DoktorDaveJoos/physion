<?php

namespace App\Listeners;

use App\Events\CustomerUpdatedFromStripe;
use App\Models\Order;
use App\Models\Product;
use App\Support\Telegram\Telegram;
use Illuminate\Support\Carbon;

class HandleOrderPaid
{
    /**
     * Handle the event.
     *
     * @param  CustomerUpdatedFromStripe  $event
     * @return void
     */
    public function handle(CustomerUpdatedFromStripe $event): void
    {
        $order = Order::find($event->reference);

        if (!$order) {
            Telegram::broadcast('Argh! Dave komm schnell, Problem: Auftrag nicht gefunden!');
            return;
        }

        $order->update([
            'meta' => $order->meta + [
                'paid' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            'status' => 'open',
        ]);

        Telegram::broadcast('🚀 Patte gemacht: ' .  $order->products->reduce(fn ($carry, Product $product) => $carry + $product->price, 0) . '0 €');
    }
}
