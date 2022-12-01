<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\TelegramSubscriber;
use Illuminate\Support\Facades\Http;

use function config;

class TelegramPublisher
{
    /**
     * @var string
     */
    private string $token;

    public function __construct()
    {
        $this->token = config('telegram.token');
    }

    public function broadcast($payload)
    {
        foreach (TelegramSubscriber::all() as $subscriber) {
            Http::post(
                sprintf(
                    'https://api.telegram.org/bot%s/sendMessage?chat_id=%s&text=%s',
                    $this->token,
                    $subscriber->name,
                    $payload
                )
            );
        }
    }

    public function sendMessage($chatId, $payload)
    {
        Http::post(
            sprintf(
                'https://api.telegram.org/bot%s/sendMessage?chat_id=%s&text=%s',
                $this->token,
                $chatId,
                $payload
            )
        );
    }

}
