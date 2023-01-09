<?php

namespace App\Http\Controllers\Verbrauch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verbrauch\CreateOrUpdateDetailsRequest;
use App\Http\Requests\Verbrauch\CreateOrUpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CreateOrUpdateDetailsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Order  $order
     * @param  CreateOrUpdateDetailsRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(Order $order, CreateOrUpdateDetailsRequest $request): RedirectResponse
    {
        if (!$order->isVerbrauch()) {
            abort(404);
        }

        $product = $order->product;

        $product->update(
            $request->validated()
        );

        $order->update([
            'meta' => [
                'completed' => array_unique([...$order->meta['completed'], ...['details']]),
            ],
        ]);

        return redirect()->route('verbrauch.consumption', $order);
    }
}
