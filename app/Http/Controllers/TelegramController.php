<?php

namespace App\Http\Controllers;

use App\Models\TelegramSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function registerSubscriber(Request $request) {
        TelegramSubscriber::create([
            'name' => json_encode($request->getContent())['chat']['id']
        ]);
        Log::info('Registered subscriber');
    }
}
