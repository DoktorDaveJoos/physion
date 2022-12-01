<?php

namespace App\Jobs;

use App\Models\DeadLetter;
use App\Models\Order;
use App\Services\Order\OrderStrategy;
use App\Support\Telegram;
use App\Support\TelegramPublisher;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $uuid;
    private mixed $payload;
    private TelegramPublisher $telegram;
    private OrderStrategy $strategy;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $uuid, mixed $payload, OrderStrategy $strategy)
    {
        $this->uuid = $uuid;
        $this->payload = $payload;
        $this->strategy = $strategy;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(sprintf('%s: Trying to create order', get_class()));

        DB::beginTransaction();
        try {
            $this->createOrder(
                $this->strategy->handle($this->payload)
            );

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            $deadLetter = new DeadLetter([
                'type' => 'order',
                'class' => ProcessOrder::class,
                'payload' => $this->payload,
                'error' => $e->getMessage(),
                'reference' => $this->uuid,
            ]);

            $deadLetter->save();

            Telegram::broadcast('Watch-out: Order konnte nicht angelegt werden!');
        }

        Telegram::broadcast('Eine Order wurde angelegt.');
    }

    private function createOrder(array $morphTuple): int
    {
        [$productID, $productClassName] = $morphTuple;

        $order = new Order([
            'reference' => $this->uuid,
            'type' => $this->payload['type'],
            'feedback' => $this->payload['feedback'],
            'product_id' => $productID,
            'product_type' => $productClassName
        ]);

        $order->save();
        return $order->id;
    }
}
