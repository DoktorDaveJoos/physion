<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        // Create reference (for Stripe)
        $uuid = (string)Uuid::uuid4();

        // Make sure Order is accepted - handle later
        ProcessOrder::dispatch($uuid, $request->all());

        return \response($uuid);
    }

}
