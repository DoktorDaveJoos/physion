<?php

namespace App\Jobs;

use App\Services\Payment\PaymentService;
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
    private string $type;

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
     */
    public function handle(PaymentService $paymentService)
    {

        Log::info(sprintf('%s: Processing payment', get_class()));

        $paymentService->process($this->type, $this->payload);
    }


}
