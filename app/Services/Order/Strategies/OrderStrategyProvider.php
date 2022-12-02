<?php

declare(strict_types=1);

namespace App\Services\Order\Strategies;

class OrderStrategyProvider
{
    public static function for(string $type): OrderStrategy
    {
        $mappings = [
            'Verbrauchsausweis' => ConsumptionStrategy::class
        ];

        return new $mappings[$type]();
    }
}
