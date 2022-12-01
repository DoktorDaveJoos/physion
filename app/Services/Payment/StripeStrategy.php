<?php

declare(strict_types=1);

namespace App\Services\Payment;

use Exception;

class StripeStrategy implements PaymentStrategy
{

    /**
     * @inheritDoc
     */
    public function handle($payload): void
    {
        // TODO: Implement handle() method.
    }
}
