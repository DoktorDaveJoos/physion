<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Models\TelegramSubscriber;
use App\Support\Telegram;
use Illuminate\Http\Request;

class AddSubscriberController extends Controller
{
    /**
     * Handles user subscription for telegram bot
     *
     * @param  Request  $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        if (TelegramSubscriber::where('name', $request->input('message.chat.id'))->first()) {
            Telegram::sendMessage(
                $request->input('message.chat.id'),
                sprintf('Bre... Lass einfach gut sein %s Danke', $request->input('message.chat.id'))
            );
            return;
        }

        TelegramSubscriber::create([
            'name' => $request->input('message.chat.id'),
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
