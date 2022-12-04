<?php

namespace App\Jobs;

use App\Services\Order\OrderService;
use App\Support\Telegram\TelegramPublisher;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $uuid;
    private mixed $payload;
    private TelegramPublisher $telegram;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $uuid, mixed $payload)
    {
        $this->uuid = $uuid;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle(OrderService $orderService)
    {
        Log::info(sprintf('%s: Processing order message', get_class()));

        $orderService->process($this->uuid, $this->payload);
    }

}
