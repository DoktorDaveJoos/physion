<?php

declare(strict_types=1);

namespace App\Services\Payment;

use Exception;

interface PaymentStrategy
{

    /**
     * @param $payload
     * @return void
     * @throws Exception
     */
    public function handle($payload): void;

}
