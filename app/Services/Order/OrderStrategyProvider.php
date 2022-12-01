<?php

declare(strict_types=1);

namespace App\Services\Order;

class OrderStrategyProvider
{
    public static function forType(string $type): string
    {
        $mappings = [
            'Verbrauchsausweis' => ConsumptionStrategy::class
        ];

        return new $mappings[$type]();
    }
}
