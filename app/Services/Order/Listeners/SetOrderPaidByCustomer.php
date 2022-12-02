<?php

namespace App\Services\Order\Listeners;

use App\Events\CustomerCreated;
use App\Models\Order;
use App\Services\DeadLetterService;
use Exception;
use Illuminate\Support\Facades\Log;

class SetOrderPaidByCustomer
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
     * @param  CustomerCreated  $event
     * @return void
     */
    public function handle(CustomerCreated $event)
    {
        try {
            $order = Order::where('reference', $event->reference)->first();
            $order->paid = true;
            $order->customer_id = $event->customerID;
            $order->save();

        } catch (Exception $e) {
            Log::error($msg = $e->getMessage());

            $this->deadLetter->commit(
                $msg,
                [$event->customerID, $event->reference],
                get_class(),
                'update_order'
            );
        }
    }
}
