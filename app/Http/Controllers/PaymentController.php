<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Services\TelegramService;
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
    private TelegramService $telegram;

    /**
     */
    public function __construct(TelegramService $service)
    {
        $this->telegram = $service;
    }

    public function index(Request $request): Response
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
            return response(400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            Log::error($e->getMessage());
            return response(400);
        } catch ( Exception $e) {
            Log::error($e->getMessage());
            return response(500);
        }

        Log::info(sprintf('%s: Webhook of type [%s]', get_class(), $event->type));
        // Handle the event
        try {
            switch ($event->type) {
                case 'checkout.session.completed':
                    $this->checkoutSessionCompleted($event->data);
                    break;

//                case 'payment_intent.succeeded':
//                    $this->paymentIntentSucceeded($event->data);
//                    break;
                // ... handle other event types
                default:
                    echo 'Received unknown event type '.$event->type;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response($e->getMessage(), 500);
        }

        return response(200);
    }


    /**
     * @throws Exception
     */
    private function checkoutSessionCompleted($data)
    {
        $customer = new Customer();
        $customer->address_line_1 = $data->object->customer_details->address->line1;
        $customer->address_line_2 = $data->object->customer_details->address->line2;
        $customer->city = $data->object->customer_details->address->city;
        $customer->postal_code = $data->object->customer_details->address->postal_code;
        $customer->state = $data->object->customer_details->address->state;
        $customer->country = $data->object->customer_details->address->country;

        $customer->name = $data->object->customer_details->name;
        $customer->email = $data->object->customer_details->email;
        $customer->phone_number = $data->object->customer_details->phone;
        $customer->save();

        // Update order
        $order = Order::find($data->object->client_reference_id);
        $order->paid = true;
        $order->customer()->associate($customer);
        $order->save();

        // TODO: Send Email -> Order created and paid

        $this->telegram->broadcast(sprintf('[%s]: 1x Verbrauchsausweis verkauft', app()->environment()));
        Log::info(sprintf('%s: Successfully created customer with id [%s]', get_class(), $customer->id));
    }

//    /**
//     * @throws Exception
//     */
//    private function paymentIntentSucceeded($data): void
//    {
//        $order = Order::where('payment_intent', $data->object->id)->first();
//
//        $order->paid = true;
//        if (!$order->save()) {
//            throw new Exception(sprintf('Could not update order with id %s', $order->id));
//        }
//        // TODO: send payment successful email -> order will be processed
//
//
//        Log::info(sprintf('%s: Successfully updated order with id: [%s]', get_class(), $order->id));
//    }

}

