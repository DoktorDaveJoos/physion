<?php

namespace App\Http\Controllers;

use App\Models\TelegramSubscriber;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function registerSubscriber(Request $request)
    {
        TelegramSubscriber::create([
            'name' => json_encode($request->getContent(), true)['message']['chat']['id'],
        ]);
        Log::info('Registered subscriber');
    }

    public function handleSentry(TelegramService $service, Request $request)
    {
        Log::info('Sentry webhook happened');
        $service->sendMessage(sprintf('[%s] - [Frontend] - Sentry issue created', app()->environment()));
    }

}
