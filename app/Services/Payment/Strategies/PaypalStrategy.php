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
        Log::error($paypalData);

        $shipping = $paypalData['shipping'];
        Log::error($shipping);

        // Address
        $customer['address_line_1'] = $shipping['address']['address_line_1'];
        $customer['city'] = $shipping['address']['admin_area_1'];
        $customer['postal_code'] = $shipping['address']['postal_code'];
        $customer['country'] = $shipping['address']['country_code'];

        $customer['name'] = $shipping['name']['full_name'];

        $customer['email'] = $payload['payer']['email_address'];

        return [
            'reference' => (string) $paypalData['reference_id'],
            'customer' => $customer
        ];
    }
}
