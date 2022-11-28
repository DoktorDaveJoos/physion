<?php

namespace App\Jobs;

use App\Models\Consumption;
use App\Models\DeadLetter;
use App\Models\Order;
use App\Models\Vacancy;
use App\Services\TelegramService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Uuid $uuid;
    private mixed $payload;
    private TelegramService $telegram;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TelegramService $service, Uuid $uuid, mixed $payload)
    {
        $this->uuid = $uuid;
        $this->payload = $payload;
        $this->telegram = $service;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(sprintf('%s: Trying to create order with payload %s', get_class(), $this->payload));

        try {
            $orderID = $this->createOrder();

            $this->createConsumptionRanges($orderID);
            $this->createVacancyRanges($orderID);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $deadLetter = new DeadLetter([
                'type' => 'order',
                'class' => ProcessOrder::class,
                'payload' => $this->payload,
                'reference' => $this->uuid,
            ]);
            $deadLetter->save();
            $this->telegram->broadcast('Watch-out: Order konnte nicht angelegt werden!');
        }

        $this->telegram->broadcast('Eine Order wurde angelegt.');
    }

    private function createOrder(): int
    {
        // Create Order with reference
        $order = new Order(
            array_merge(
                $this->payload,
                ['reference' => $this->uuid]
            )
        );

        $order->save();
        return $order->id;
    }

    private function createConsumptionRanges($orderID)
    {
        foreach ($this->payload['consumption_range'] as $source) {
            foreach ($source['range'] as $range) {
                $consumption = new Consumption(
                    array_merge(
                        ['source' => $source],
                        $range
                    )
                );

                $consumption->order()->associate($orderID);
                $consumption->save();
            }
        }
    }

    private function createVacancyRanges($orderID)
    {
        if ($percentage = $this->payload['vacancy_percentage']) {
            $vacancy = new Vacancy([
                'percentage' => $percentage,
            ]);
            $vacancy->order()->associate($orderID);
            $vacancy->save();
            return;
        }

        foreach ($this->payload['vacancy_range'] as $range) {
            $vacancy = new Vacancy($range);

            $vacancy->order()->associate($orderID);
            $vacancy->save();
        }
    }

}
