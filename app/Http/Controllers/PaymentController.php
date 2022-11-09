<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;
use Stripe\Webhook;

class PaymentController extends Controller
{
    public function index(Request $request) {

        $payload = $request->getContent();
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

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
        }

        // Handle the event
        switch ($event->type) {

            case 'checkout.session.completed':
                $this->checkoutSessionCompleted($event->data);
                break;

            case 'payment_intent.succeeded':
                $this->paymentIntentSucceeded($event->data);
                break;
            // ... handle other event types
            default:
                echo 'Received unknown event type '.$event->type;
        }

        return response(200);
    }


    private function checkoutSessionCompleted($data) {

        // Create customer
        $customer = new Customer();
        $customer->address_line_1 = $data->object->customer_details->address->line1;
        $customer->address_line_2 = $data->object->customer_details->address->line2;
        $customer->city= $data->object->customer_details->address->city;
        $customer->postal_code = $data->object->customer_details->address->postal_code;
        $customer->state = $data->object->customer_details->address->state;
        $customer->country = $data->object->customer_details->address->country;

        $customer->name = $data->object->customer_details->name;
        $customer->email = $data->object->customer_details->email;
        $customer->phone_number = $data->object->customer_details->phone;
        $customer->save();

        // Update order
        $order = Order::find($data->object->client_reference_id);
        $order->payment_intent = $data->object->payment_intent;
        $order->customer()->associate($customer);
        $order->save();
    }

    private function paymentIntentSucceeded($data) {
        $order = Order::where('payment_intent', $data->object->id)->first();

        $order->paid = true;
        $order->save();

        // TODO: send payment successful email -> order will be processed
    }

}

