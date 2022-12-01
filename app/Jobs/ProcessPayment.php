<?php

namespace App\Jobs;

use App\Models\DeadLetter;
use App\Services\Customer\CustomerService;
use App\Services\Payment\PaymentStrategy;
use App\Support\Telegram;
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

    private mixed $payload;
    private PaymentStrategy $strategy;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PaymentStrategy $strategy, mixed $payload)
    {
        $this->strategy = $strategy;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->strategy->handleCustomer($this->payload);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $deadLetter = new DeadLetter([
                'type' => 'customer',
                'class' => ProcessPayment::class,
                'reference' => null,
                'payload' => $this->payload,
            ]);
            $deadLetter->save();
            Telegram::broadcast('Watch-out: Customer konnte nicht angelegt werden!');
        }
        Telegram::broadcast('Conversion: Ein Ausweis wurde verkauft!');
    }
}
