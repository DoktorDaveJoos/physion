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
    }

    public function handleSentry(TelegramService $service, Request $request)
    {
        Log::info('Sentry webhook happened');
        $service->broadcast(sprintf('[%s] - [Frontend] - Sentry issue created', app()->environment()));
    }

}
