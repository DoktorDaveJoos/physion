<?php

namespace App\Services\Order;

use App\Events\CustomerCreated;
use App\Models\Order;
use App\Support\Telegram\Telegram;

class SetOrderPaidByCustomer
{
    /**
     * Handle the event.
     *
     * @param  CustomerCreated  $event
     * @return void
     */
    public function handle(CustomerCreated $event)
    {
        $order = Order::where('reference', $event->reference)->first();
        $order->paid = true;
        $order->status = 'open';
        $order->customer_id = $event->customerID;
        $order->save();

        Telegram::broadcast('🚀 Kunde angelegt, Auftrag bezahlt. Patte gemacht!!!');
    }
}
