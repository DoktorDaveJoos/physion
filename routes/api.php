
<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\Payment\PaypalController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\Telegram\AddSubscriberController;
use App\Http\Controllers\Telegram\SentryWebhookController;
use App\Http\Controllers\Telegram\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Handle order creation
Route::post('/order', OrderController::class);

// Handle payments
Route::post('/payment/stripe', StripeController::class);
Route::post('/payment/paypal', PaypalController::class);

// Realtime logging
// To enable the telegram bot sending messages:
// POSTMAN: https://api.telegram.org/bot<BOT_TOKEN>/setWebhook?url=<URL>/api/telegram
Route::post('/telegram/subscribe', AddSubscriberController::class );
Route::post('/telegram/sentry', SentryWebhookController::class);
