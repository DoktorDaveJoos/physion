<?php

namespace App\Services\Customer;

use App\Events\CustomerCreated;
use App\Events\PaymentCreated;
use App\Mail\OrderCreated;
use App\Models\Customer;
use App\Services\Stripe\StripeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ItemNotFoundException;
use Stripe\Exception\ApiErrorException;

class CreateCustomer
{
    private StripeService $stripe;

    public function __construct(StripeService $stripe)
    {
        $this->stripe = $stripe;
    }


    /**
     * Handle the event.
     *
     * @param  PaymentCreated  $event
     * @return void
     * @throws ApiErrorException
     */
    public function handle(PaymentCreated $event)
    {
        try {
            $customer = Customer::where('email', $event->payload['customer']['email'])
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            Log::info(sprintf('%s: Create new Customer', $e->getMessage()));
            $customer = new Customer(
                $event->payload['customer']
            );
            $customer->save();
        }

        Mail::to($customer->email)->send(new OrderCreated($customer->name));

        if ($customer->unknownToStripe()) {
            $this->stripe->syncWithStripe($customer);
        }

        if ($customer->checkout !== 'stripe') {
            $this->stripe->createInvoice($customer);
        }

        CustomerCreated::dispatch($customer->id, $event->payload['reference']);
    }
}
