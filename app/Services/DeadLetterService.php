<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\DeadLetter;
use App\Support\Telegram;

class DeadLetterService
{

    public function commit(
        string $error,
        string|array $payload,
        string $class,
        string $type,
        string|null $reference = null,
    ) {
        $deadLetter = new DeadLetter([
            'type' => $type,
            'class' => $class,
            'payload' => is_array($payload) ? json_encode($payload) : $payload,
            'error' => $error,
            'reference' => $reference,
        ]);

        $deadLetter->save();

        Telegram::broadcast((sprintf('Watch-out: Fehler bei [%s] aufgetreten.', $type)));
    }
}
