<?php

namespace App\Services\Customer;

use App\Events\CustomerCreated;
use App\Events\PaymentCreated;
use App\Mail\OrderCreated;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;

class CreateCustomer
{
    /**
     * Handle the event.
     *
     * @param  PaymentCreated  $event
     * @return void
     */
    public function handle(PaymentCreated $event)
    {
        $customer = new Customer(
            $event->payload['customer']
        );

        $customer->save();

        Mail::to($customer->email)->send(new OrderCreated($customer->name));

        CustomerCreated::dispatch($customer->id, $event->payload['reference']);
    }
}
