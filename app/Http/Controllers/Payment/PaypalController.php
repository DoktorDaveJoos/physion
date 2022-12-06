<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessPayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

use function response;

class PaypalController extends Controller
{
    /**
     * Handles a paypal order capture
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        Log::info(sprintf('%s: Incoming PayPal Payment', get_class()));

        ProcessPayment::dispatch(
            'paypal',
            $request->all()
        );

        return new JsonResponse(['message' => 'Success']);
    }
}

