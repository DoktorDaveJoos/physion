<?php

namespace App\Http\Controllers\Verbrauch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Vrbr\MarkDoneConsumptionRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;

class MarkDoneConsumptionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Order  $order
     * @param  MarkDoneConsumptionRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(Order $order, MarkDoneConsumptionRequest $request): RedirectResponse

    {
        if ($request->get('percentage') !== null) {
            $order->product->update(['vacancy_percentage' => $request->get('percentage')]);

            foreach ($order->product->vacancies as $vacancy) {
                $vacancy->delete();
            }
        }

        $order->update(['meta' => [
            'completed' => array_unique(array_merge($order->meta['completed'] ?? [], ['consumption'])),
        ]]);

        return redirect()->route('verbrauch.summary', $order->id);
    }
}
