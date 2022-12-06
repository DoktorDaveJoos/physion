<?php

declare(strict_types=1);

namespace App\Services\Payment\Strategies;

use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\ArrayShape;

class PaypalStrategy implements PaymentStrategy
{
    #[ArrayShape(['reference' => "string", 'customer' => "array"])]
    public function normalize(mixed $payload): array
    {
        $customer = [];

        // Always zero indexed
        $paypalData = $payload['purchase_units'][0];
        $shipping = $paypalData['shipping'];

        ray($shipping);

        // Address
        $customer['address_line_1'] = $shipping['address']['address_line_1'];
        if (!($city = $shipping['address']['admin_area_1'] ?? null)) {
            $city = $shipping['address']['admin_area_2'] ?? 'Keine Angabe';
        }
        $customer['city'] = $city;
        $customer['postal_code'] = $shipping['address']['postal_code'];
        $customer['country'] = $shipping['address']['country_code'];

        $customer['name'] = $shipping['name']['full_name'];

        $customer['email'] = $payload['payer']['email_address'];

        $customer['checkout'] = 'paypal';

        return [
            'reference' => (string) $paypalData['reference_id'],
            'customer' => $customer
        ];
    }
}
