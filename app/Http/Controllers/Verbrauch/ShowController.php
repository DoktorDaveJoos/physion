<?php

namespace App\Http\Controllers\Verbrauch;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Vrbr;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Verbrauch/Index', [
            'title' => 'Verbrauchsausweis',
            'context' => 'verbrauch',
            'subtitle' => 'Anlegen',
            'step' => 'general'
        ]);
    }

    /**
     * Handle the incoming request.
     *
     * @param  Order  $order
     * @return Response
     */
    public function general(Order $order): Response
    {

        return Inertia::render('Verbrauch/General', [
            'title' => 'Verbrauchsausweis',
            'subtitle' => 'Allgemeine Informationen',
            'step' => 'general',
            'context' => 'verbrauch',
            'order' => $order,
            'product' => $order->product,
            'customer' => $order->customer,
        ]);
    }

    /**
     * Handle the incoming request.
     *
     * @param  Order  $order
     * @return Response
     */
    public function details(Order $order): Response
    {
        return Inertia::render('Verbrauch/Details', [
            'title' => 'Verbrauchsausweis',
            'subtitle' => 'Allgemeine Informationen',
            'step' => 'details',
            'context' => 'verbrauch',
            'order' => $order,
            'product' => $order->product,
            'customer' => $order->customer,
        ]);
    }

    /**
     * Handle the incoming request.
     *
     * @param  Order  $order
     * @return Response
     */
    public function consumption(Order $order): Response
    {

        $product = Vrbr::with(['sources.periods', 'vacancies'])->find($order->product->id);

        return Inertia::render('Verbrauch/Consumption', [
            'title' => 'Verbrauchsausweis',
            'subtitle' => 'Allgemeine Informationen',
            'step' => 'consumption',
            'context' => 'verbrauch',
            'order' => $order,
            'product' => $product,
        ]);
    }

    /**
     * Handle the incoming request.
     *
     * @param  Order  $order
     * @return Response
     */
    public function summary(Order $order): Response
    {

        $product = Vrbr::with(['sources.periods', 'vacancies'])->find($order->product->id);

        return Inertia::render('Verbrauch/Summary', [
            'title' => 'Verbrauchsausweis',
            'subtitle' => 'Allgemeine Informationen',
            'step' => 'summary',
            'context' => 'verbrauch',
            'order' => $order,
            'product' => $product,
            'customer' => $order->customer,
        ]);
    }
}
