<?php

declare(strict_types=1);

namespace App\Services\Customer;

use JetBrains\PhpStorm\ArrayShape;

class PaypalCustomerService extends CustomerService
{

    #[ArrayShape(['reference' => "string", 'customer' => "array"])]
    protected function normalize(mixed $payload): array
    {
        $customer = [];

        // Always zero indexed
        $paypalData = $payload['purchase_units'][0];

        // Address
        $customer['address_line_1'] = $paypalData['address']['address_line_1'];
        $customer['city'] = $paypalData['address']['admin_area_1'];
        $customer['postal_code'] = $paypalData['address']['postal_code'];
        $customer['country'] = $paypalData['address']['country_code'];

        $customer['name'] = $paypalData['name']['full_name'];
        $customer['email'] = $payload['payer']['email_address'];

        return [
            'reference' => (string) $payload['id'],
            'customer' => $customer
        ];
    }

    protected function reference(): string
    {
        return 'payment_intent';
    }
}
