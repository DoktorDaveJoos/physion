<?php

namespace App\Http\Controllers\Bedarf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verbrauch\CreateOrUpdateDetailsRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;

class DetailsController extends Controller
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
        if (!$order->isBedarf()) {
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

        return redirect()->route('bedarf.position', $order);
    }



}
