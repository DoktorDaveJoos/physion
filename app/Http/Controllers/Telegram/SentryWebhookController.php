<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Support\Telegram\Telegram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SentryWebhookController extends Controller
{
    /**
     * Handles sentry webhooks
     *
     * @param  Request  $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        Log::info('Sentry webhook happened');
        Telegram::broadcast('Sentry Alert happened!');
    }

}
