<?php

declare(strict_types=1);

namespace App\Services\Order\Strategies;

use Exception;

interface OrderStrategy
{
    /**
     * @param $payload
     * @return array Returns a tuple of the product ID and the associated class name
     * @throws Exception
     */
    public function handle($payload): array;
}
