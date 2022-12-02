<?php

namespace App\Services\Customer\Listeners;

use App\Events\CustomerCreated;
use App\Events\PaymentDataNormalized;
use App\Models\Customer;
use App\Services\DeadLetterService;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateCustomer
{

    private DeadLetterService $deadLetter;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DeadLetterService $deadLetterService)
    {
        $this->deadLetter = $deadLetterService;
    }

    /**
     * Handle the event.
     *
     * @param  PaymentDataNormalized  $event
     * @return void
     */
    public function handle(PaymentDataNormalized $event)
    {
        try {
            $customer = new Customer(
                $event->payload['customer']
            );

            $customer->save();

            CustomerCreated::dispatch($customer->id, $event->payload['reference']);
        } catch (Exception $e) {
            Log::error($msg = $e->getMessage());

            $this->deadLetter->commit(
                $msg,
                $event->payload,
                get_class(),
                'create_customer'
            );
        }
    }
}
