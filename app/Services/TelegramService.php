<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\TelegramSubscriber;
use Illuminate\Support\Facades\Http;

class TelegramService
{
    /**
     * @var string
     */
    private string $token;

    /**
     */
    public function __construct()
    {
        $this->token = config('telegram.token');
    }


    public function sendMessage($payload)
    {
        foreach (TelegramSubscriber::all() as $subscriber) {
            Http::post(
                sprintf(
                    'https://api.telegram.org/bot%s/sendMassge?chat_id=%s&text=geisteskrank',
                    $this->token,
                    $subscriber->name
                )
            );
        }
    }

}
