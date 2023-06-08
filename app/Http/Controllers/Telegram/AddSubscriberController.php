<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Models\TelegramSubscriber;
use App\Support\Telegram\Telegram;
use Illuminate\Http\Request;

class AddSubscriberController extends Controller
{
    /**
     * Handles user subscription for telegram bot
     *
     * @param  Request  $request
     * @return void
     */
    public function __invoke(Request $request): void
    {
        if (TelegramSubscriber::where('username', $request->input('message.from.username'))->first()) {
            Telegram::sendMessage(
                $request->input('message.chat.id'),
                sprintf('Bre... Lass es gut sein, %s', $request->input('message.from.username'))
            );
            return;
        }

        TelegramSubscriber::create([
            'user_telegram_id' => $request->input('message.from.id'),
            'chat_id' => $request->input('message.chat.id'),
            'first_name' => $request->input('message.from.first_name'),
            'last_name' => $request->input('message.from.last_name'),
            'username' => $request->input('message.from.username'),
        ]);

        Telegram::sendMessage(
            $request->input('message.chat.id'),
            sprintf(
                'Hallo %s! Du hast dich erfolgreich für die Updates vom EnergieBiz registriert.',
                $request->input('message.from.username')
            )
        );
    }
}
