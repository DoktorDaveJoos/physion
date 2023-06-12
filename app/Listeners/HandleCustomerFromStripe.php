<?php

namespace App\Listeners;

use App\Events\CustomerUpdatedFromStripe;
use App\Events\PaymentCreated;
use App\Mail\OrderCreated;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
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

        $customer = Customer::where('email', $event->payload['customer']['email'])->first();

        throw_if(!$customer, new RuntimeException('Customer not created'));

        $customer->update($event->payload['customer']);

        CustomerUpdatedFromStripe::dispatch($customer->id, $event->payload['reference']);
    }
}
