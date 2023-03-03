<?php

namespace App\Http\Controllers\Bedarf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Vrbr\UpdateDetailsRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;

class DetailsController extends Controller
{

    /**
     * Handle the incoming request.
     *
     * @param  Order  $order
     * @param  UpdateDetailsRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(Order $order, UpdateDetailsRequest $request): RedirectResponse
    {

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
