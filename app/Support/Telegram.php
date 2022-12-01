<?php

declare(strict_types=1);

namespace App\Support;


use Illuminate\Support\Facades\Facade;

/**
 * @method static TelegramPublisher broadcast(string $message): void
 * @method static TelegramPublisher sendMessage(string $chatId, string $message): void
 */
class Telegram extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'telegram';
    }
}
