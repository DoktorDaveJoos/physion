<?php

namespace App\Listeners;

use App\Events\CustomerUpdatedFromStripe;
use App\Jobs\BroadcastMessageJob;
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

        $price = $order->products->reduce(function (float $carry, Product $product) {
            return $carry + $product->price;
        }, 0.0);

        BroadcastMessageJob::dispatch(
            sprintf(
                '🚀 Patte gemacht: %s€ bezahlt von %s %s für %s Produkte.',
                $price,
                $order->owner->first_name,
                $order->owner->last_name,
                $order->products->count()
            )
        );
    }
}
