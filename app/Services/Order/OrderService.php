<?php

declare(strict_types=1);

namespace App\Services\Order;

use App\Models\Order;
use App\Services\DeadLetterService;
use App\Services\Order\Strategies\OrderStrategyProvider;
use App\Support\Telegram;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    private DeadLetterService $deadLetter;

    public function __construct(DeadLetterService $deadLetterService)
    {
        $this->deadLetter = $deadLetterService;
    }

    public function process($uuid, $payload)
    {
        DB::beginTransaction();

        try {
            $this->createOrder(
                $uuid,
                $payload,
                OrderStrategyProvider::for($payload['type'])
                    ->handle($payload)
            );

            DB::commit();
            Telegram::broadcast('Eine Order wurde angelegt.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($msg = $e->getMessage());

            $this->deadLetter->commit(
                $msg,
                $payload,
                get_class(),
                'create_order',
                $uuid,
            );
        }
    }

    private function createOrder(string $uuid, array $payload, array $morphTuple): void
    {
        [$productID, $productClassName] = $morphTuple;

        $order = new Order([
            'reference' => $uuid,
            'type' => $payload['type'],
            'feedback' => $payload['feedback'],
            'product_id' => $productID,
            'product_type' => $productClassName,
        ]);

        $order->save();
    }

}
