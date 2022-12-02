<?php

namespace App\Jobs;

use App\Events\PaymentCreated;
use App\Services\Payment\PaymentService;
use App\Services\Payment\Strategies\PaymentStrategyProvider;
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

    private string $type;
    private mixed $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $type, mixed $payload)
    {
        $this->type = $type;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        Log::info(sprintf('%s: Processing payment for %s', get_class(), $this->type));

        $normalized = PaymentStrategyProvider::for($this->type)->normalize($this->payload);

        PaymentCreated::dispatch($normalized);
    }


}
