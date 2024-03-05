<?php

namespace App\Listeners;

use App\Events\PaymentCreated;
use Stripe\Exception\ApiErrorException;
use Throwable;

class HandleCustomerFromStripe
{

    /**
     * Handle the event.
     *
     * @param  PaymentCreated  $event
     * @return void
     * @throws ApiErrorException
     * @throws Throwable
     */
    public function handle(PaymentCreated $event): void
    {
//        $order = Order::find($event->payload['reference']);
//
//        if (!$order) {
//            throw new RuntimeException('Order not found for customer: '.$event->payload['customer']['email']);
//        }
//
//        $customer = $order->owner;
//
//        $customer->update($event->payload['customer']);
//
//        CustomerUpdatedFromStripe::dispatch($customer->id, $event->payload['reference']);
    }
}
