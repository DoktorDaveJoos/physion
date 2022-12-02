<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessOrder;
use App\Services\Order\Strategies\OrderStrategyProvider;
use App\Support\Telegram;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class OrderController extends Controller
{
    /**
     * Enqueue order from sales page
     *
     * @param  Request  $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        // Create reference (for Stripe & Paypal)
        $uuid = (string)Uuid::uuid4();

        $validator = Validator::make($request->all(), [
            'type' => 'required',
        ]);

        if($validator->fails()) {
            Telegram::broadcast('Watch-out: Request failed, check telescope');
            return response('Bad request', 400);
        }

        $content = $request->all();

        // Make sure Order is accepted - handle later
        ProcessOrder::dispatch(
            $uuid,
            $content,
            OrderStrategyProvider::for($content['type'])
        );

        return response($uuid);
    }
}
