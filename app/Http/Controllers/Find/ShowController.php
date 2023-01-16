<?php

namespace App\Http\Controllers\Find;

use App\Http\Controllers\Controller;
use App\Http\Requests\Find\FindRequest;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowController extends Controller
{

    /**
     * @return Response
     */
    public function index(FindRequest $request): Response
    {
        $orders = [];

        if ($request->has('order_id')) {
            $order = Order::find($request->input('order_id'));
            if ($order) {
                $orders[] = $order;
            }
        }

        if ($request->has('email')) {
            $orders = Customer::where('email', $request->input('email'))->first()->orders;

            $orders->filter(function ($order) use($request) {
                return $order->product->zip === $request->input('zip');
            });
        }

        return Inertia::render('Find/Index', [
            'orders' => $orders,
        ]);
    }

}
