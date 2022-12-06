<?php

declare(strict_types=1);

namespace App\Services\Payment\Strategies;

class PaymentStrategyProvider
{

    public static function for(string $type): PaymentStrategy {
        $mappings = [
            'stripe' => StripeStrategy::class,
            'paypal' => PaypalStrategy::class
        ];

        return new $mappings[$type]();
    }

}
