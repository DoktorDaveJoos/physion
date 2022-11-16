<?php

namespace App\Http\Controllers;

use App\Models\Consumption;
use App\Models\Order;
use App\Models\Vacancy;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
//    public function index(): Response
//    {
//        //
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
//    public function create(): Response
//    {
//
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        try {
            $order = new Order($request->all());
            $order->suggestion_check = json_encode($order->suggestion_check);
            if (!$order->save()) {
                ray('not reached');
                throw new Exception(sprintf('%s: Error saving order', get_class()), 500);
            }
ray(1);
            foreach ($request->all()['consumption_range'] as $source) {
                foreach ($source['range'] as $range) {
                    $consumption = new Consumption([
                        'source' => $source['source'],
                        'start' => $range['start'],
                        'end' => $range['end'],
                        'consumption' => $range['consumption'],
                        'water' => $range['water'] ?? null,
                    ]);

                    $consumption->order()->associate($order);
                    if (!$consumption->save()) {
                        throw new Exception(sprintf('%s: Error saving consumption', get_class()), 500);
                    }
                }
            }
ray(2);
            if ($percentage = $request->all()['vacancy_percentage']) {
                $vacancy = new Vacancy([
                    'percentage' => $percentage,
                ]);
                $vacancy->order()->associate($order);
                $vacancy->save();
            } else {
                foreach ($request->all()['vacancy_range'] as $range) {
                    $vacancy = new Vacancy([
                        'start' => $range['start'],
                        'end' => $range['end'],
                    ]);

                    $vacancy->order()->associate($order);
                    if (!$vacancy->save()) {
                        throw new Exception(sprintf('%s: Error saving vacancy', get_class()), 500);
                    }
                }
            }
        } catch (Exception $e) {
            ray($e);
            return response($e->getMessage(), 500);
        }

        return response($order->id, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Order  $order
     * @return Response
     */
//    public function show(Order $order): Response
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order  $order
     * @return Response
     */
//    public function edit(Order $order): Response
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Order  $order
     * @return Response
     */
//    public function update(Request $request, Order $order)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order  $order
     * @return Response
     */
//    public function destroy(Order $order)
//    {
//        //
//    }
}
