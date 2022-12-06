<?php

declare(strict_types=1);

namespace App\Services\Order;

use App\Models\Order;
use App\Services\Order\Strategies\OrderStrategyProvider;
use App\Support\Telegram\Telegram;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{

    /**
     * @throws Exception
     */
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
            // Catching the exception, to not pollute database
            DB::rollBack();

            throw $e;
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
