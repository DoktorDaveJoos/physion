<?php

declare(strict_types=1);

namespace App\Support\Telegram;

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

    public function broadcast($payload): void
    {
        foreach (TelegramSubscriber::all() as $subscriber) {
            Http::post(
                sprintf(
                    'https://api.telegram.org/bot%s/sendMessage?chat_id=%s&text=%s',
                    $this->token,
                    $subscriber->username,
                    $payload
                )
            );
        }
    }

    public function sendMessage($chatId, $payload): void
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
