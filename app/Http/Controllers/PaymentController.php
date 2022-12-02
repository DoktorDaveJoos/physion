<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPayment;
use App\Services\Payment\Strategies\PaypalStrategy;
use App\Services\Payment\Strategies\StripeStrategy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;
use Stripe\Stripe;
use Stripe\Webhook;

class PaymentController extends Controller
{

    /**
     * @throws Exception
     */
    public function paypal(Request $request): Response
    {
        Log::info(sprintf('%s: Incoming PayPal Payment', get_class()));


        ProcessPayment::dispatch(
            $request->all(),
            new PaypalStrategy()
        );

        return response('Successfully captured payment');
    }

    public function stripe(Request $request): Response
    {
        Log::info(sprintf('%s: Incoming Webhook', get_class()));

        $payload = $request->getContent();
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        Stripe::setApiKey(config('stripe.api_key'));

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                config('stripe.endpoint_secret')
            );
        } catch (UnexpectedValueException $e) {
            // Invalid payload
            Log::error($e->getMessage());
            return response($e->getMessage(), 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            Log::error($e->getMessage());
            return response($e->getMessage(), 400);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response($e->getMessage(), 500);
        }

        // Handle the event
        try {
            switch ($event->type) {
                case 'checkout.session.completed':
                    ProcessPayment::dispatch(
                        $event->data,
                        new StripeStrategy()
                    );
                    break;
                default:
                    Log::info('Received unknown event type '.$event->type);
                    echo 'Received unknown event type '.$event->type;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response($e->getMessage(), 500);
        }

        return response('success');
    }
}

