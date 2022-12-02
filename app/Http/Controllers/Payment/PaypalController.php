<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessPayment;
use App\Services\Payment\Strategies\PaypalStrategy;
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
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        Log::info(sprintf('%s: Incoming PayPal Payment', get_class()));

        ProcessPayment::dispatch(
            'paypal',
            $request->all()
        );

        return response('Successfully captured payment');
    }
}

