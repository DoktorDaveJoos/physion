<?php

namespace App\Http\Controllers;

use App\Models\TelegramSubscriber;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function registerSubscriber(TelegramService $service, Request $request)
    {
        if (empty(TelegramSubscriber::where('name', '=', $request->input('message.chat.id'))->get())) {
            TelegramSubscriber::create([
                'name' => $request->input('message.chat.id'),
            ]);
            Log::info('Registered subscriber');
            $service->sendMessage(
                $request->input('message.chat.id'),
                sprintf(
                    'Hallo %s! Willkommen, du hast dich für die Updates von EnergieBiz registriert.',
                    $request->input('message.from.username')
                )
            );
            return;
        }

        $service->sendMessage(
            $request->input('message.chat.id'),
            'Du bist schon registriert, sieh bitte von Nachrichten an den Bot ab. Danke'
        );
    }

    public function handleSentry(TelegramService $service, Request $request)
    {
        Log::info('Sentry webhook happened');
        $service->broadcast(sprintf('[%s] - [Frontend] - Sentry issue created', app()->environment()));
    }

}
