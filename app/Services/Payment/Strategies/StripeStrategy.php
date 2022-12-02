<?php

declare(strict_types=1);

namespace App\Services\Payment\Strategies;

use JetBrains\PhpStorm\ArrayShape;

class StripeStrategy implements PaymentStrategy
{
    #[ArrayShape(['reference' => "string", 'customer' => "array"])]
    public function normalize(mixed $payload): array
    {
        $customer = [];

        $customer['address_line_1 ']= $payload->object->customer_details->address->line1;
        $customer['address_line_2'] = $payload->object->customer_details->address->line2;
        $customer['city'] = $payload->object->customer_details->address->city;
        $customer['postal_code'] = $payload->object->customer_details->address->postal_code;
        $customer['state'] = $payload->object->customer_details->address->state;
        $customer['country'] = $payload->object->customer_details->address->country;

        $customer['name'] = $payload->object->customer_details->name;
        $customer['email'] = $payload->object->customer_details->email;
        $customer['phone_number'] = $payload->object->customer_details->phone;

        return [
            'reference' => (string) $payload->object->client_reference_id,
            'customer' => $customer
        ];
    }
}
