<?php

declare(strict_types=1);

namespace App\Services\Stripe;


use App\Models\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeService
{

    private StripeClient $client;

    public function __construct(StripeClient $client)
    {
        $this->client = $client;
    }

    /**
     * @throws ApiErrorException
     */
    public function syncWithStripe(Customer $customer)
    {
        $stripeCustomer = $this->client->customers->create([
            'email' => $customer->email,
            'shipping' => [
                'address' => [
                    'city' => $customer->city,
                    'line1' => $customer->address_line_1,
                    'postal_code' => $customer->postal_code,

                ],
                'name' => $customer->name,
            ],
            'description' => 'Paid with Paypal',
            'name' => $customer->name,
        ]);

        $customer->stripe_id = $stripeCustomer->id;
        $customer->save();
    }

    /**
     * @throws ApiErrorException
     */
    public function createInvoice(Customer $customer) {
        $invoice = $this->client->invoices->create([
            'customer' => $customer->stripe_id,
            'collection_method' => 'send_invoice',
            'footer' => 'Vollständig bezahlt mit PayPal. Danke für Ihren Einkauf.',
            'days_until_due' => 0,
        ]);

        $this->client->invoiceItems->create([
            'invoice' => $invoice->id,
            'customer' => $customer->stripe_id,
            'price' => config('stripe.price'),
        ]);

        $this->client->invoices->pay(
            $invoice->id,
            [
                'paid_out_of_band' => true,
            ]
        );
    }

}
