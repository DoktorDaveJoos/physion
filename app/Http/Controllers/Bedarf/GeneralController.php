<?php

namespace App\Http\Controllers\Bedarf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verbrauch\CreateOrUpdateRequest;
use App\Models\Bdrf;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Vrbr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class GeneralController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Order  $order
     * @param  CreateOrUpdateRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(Order $order, CreateOrUpdateRequest $request): RedirectResponse
    {
        Customer::where('id', $order->customer_id)->update(
            $request->safe()->only('name', 'email', 'phone')
        );

        Bdrf::where('id', $order->product_id)->update(
            $request->safe()->only('street_address', 'zip', 'city', 'reason', 'type', 'additional_type')
        );

        $order->update([
            'meta' => [
                'completed' => array_unique([...$order->meta['completed'], ...['general']]),
            ],
        ]);

        return Redirect::route('bedarf.details', $order->id);
    }
}
