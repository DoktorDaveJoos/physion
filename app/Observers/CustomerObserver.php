<?php

namespace App\Observers;

use App\Models\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class CustomerObserver
{

    /**
     */
    public function __construct(public StripeClient $client)
    {
    }

    /**
     * @throws ApiErrorException
     */
    public function created(Customer $customer): void
    {
        $stripeCustomer = $this->client->customers->create([
            'email' => $customer->email,
            'name' => $customer->name,
            'phone' => $customer->phone,
        ]);

        $customer->update(['stripe_customer_id' => $stripeCustomer->id]);
    }

    /**
     * @param  Customer  $customer
     *
     * @throws ApiErrorException
     */
    public function updated(Customer $customer): void
    {
        if ($customer->isDirty('phone')) {
            $this->client->customers->update(
                $customer->stripe_customer_id,
                ['phone' => $customer->phone]
            );
        }
    }

}
