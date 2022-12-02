<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Events\PaymentDataNormalized;
use App\Events\CustomerCreated;
use App\Services\DeadLetterService;
use App\Services\Payment\Strategies\PaymentStrategyProvider;
use App\Support\Telegram;
use Exception;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    private DeadLetterService $deadLetter;

    /**
     */
    public function __construct(DeadLetterService $deadLetterService)
    {
        $this->deadLetter = $deadLetterService;
    }

    public function process($type, $payload) {

        try {

            $normalized = PaymentStrategyProvider::for($type)->normalize($payload);

            CustomerCreated::dispatch($normalized['reference']);
            PaymentDataNormalized::dispatch($normalized['customer']);


        } catch (Exception $e) {
            Log::error($msg = $e->getMessage());

            $this->deadLetter->commit(
                $msg,
                $payload,
                get_class(),
                'normalize_payment'
            );
        }



    }


}
