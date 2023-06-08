<?php

namespace App\Services\Customer;

use App\Events\CustomerCreated;
use App\Events\PaymentCreated;
use App\Mail\OrderCreated;
use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Stripe\Exception\ApiErrorException;
use Throwable;

class CreateCustomer
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
        throw_if(
            !Customer::updateOrInsert(
                ['email' => $event->payload['customer']['email']],
                $event->payload['customer']
            ),
            new RuntimeException('Customer not created')
        );

        $customer = Customer::where('email', $event->payload['customer']['email'])->first();

        Mail::to($customer->email)->send(new OrderCreated($customer->name));

        CustomerCreated::dispatch($customer->id, $event->payload['reference']);
    }
}
