<?php

declare(strict_types=1);

namespace App\Services\Payment\Strategies;

use JetBrains\PhpStorm\ArrayShape;

class StripeStrategy
{
    #[ArrayShape(['reference' => "string", 'customer' => "array"])]
    public static function normalize(mixed $payload): array
    {
        $customer = [];

        $customer['address_line_1'] = $payload->customer_details->address->line1;
        $customer['address_line_2'] = $payload->customer_details->address->line2;
        $customer['city'] = $payload->customer_details->address->city;
        $customer['zip'] = $payload->customer_details->address->postal_code;
        $customer['state'] = $payload->customer_details->address->state;
        $customer['country'] = $payload->customer_details->address->country;

        $customer['email'] = $payload->customer_details->email;

        return [
            'reference' => $payload->client_reference_id,
            'customer' => $customer,
        ];
    }
}
