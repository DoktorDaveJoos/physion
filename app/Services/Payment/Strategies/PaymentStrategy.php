<?php

declare(strict_types=1);

namespace App\Services\Payment\Strategies;

use Exception;
use JetBrains\PhpStorm\ArrayShape;

interface PaymentStrategy
{

    /**
     * @param $payload
     * @return array
     * @throws Exception
     */
    #[ArrayShape(['reference' => "string", 'customer' => "array"])]
    public function normalize($payload): array;

}
