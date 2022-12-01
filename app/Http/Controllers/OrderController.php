<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessOrder;
use App\Services\Order\OrderStrategyProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        // Create reference (for Stripe)
        $uuid = (string)Uuid::uuid4();

        $content = $request->all();

        // Make sure Order is accepted - handle later
        ProcessOrder::dispatch(
            $uuid,
            $content,
            OrderStrategyProvider::forType($content["type"])
        );

        return response($uuid);
    }
}


