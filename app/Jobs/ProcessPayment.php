<?php

namespace App\Jobs;

use App\Models\DeadLetter;
use App\Services\Customer\CustomerService;
use App\Services\TelegramService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private CustomerService $service;
    private mixed $payload;
    private TelegramService $telegram;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TelegramService $telegram, CustomerService $service, mixed $payload)
    {
        $this->service = $service;
        $this->payload = $payload;
        $this->telegram = $telegram;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->service->handleCustomer($this->payload);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $deadLetter = new DeadLetter([
                'type' => 'customer',
                'class' => ProcessPayment::class,
                'reference' => null,
                'payload' => $this->payload,
            ]);
            $deadLetter->save();
            $this->telegram->broadcast('Watch-out: Customer konnte nicht angelegt werden!');
        }

        $this->telegram->broadcast('Conversion: Ein Ausweis wurde verkauft!');
    }
}
