<?php

namespace App\Http\Controllers\Verbrauch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verbrauch\CreateOrUpdateRequest;
use App\Models\Bdrf;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Vbrc;
use Hidehalo\Nanoid\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  CreateOrUpdateRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(CreateOrUpdateRequest $request): RedirectResponse
    {
        $client = new Client();
        $id = $client->formattedId('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 9);

        $customer = Customer::firstOrCreate([
            'email' => $request->get('email'),
        ], [
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
        ]);

        $product = Vbrc::create([
            'street_address' => $request->get('street_address'),
            'zip' => $request->get('zip'),
            'city' => $request->get('city'),
            'place_id' => $request->get('place_id'),
            'reason' => $request->get('reason'),
            'type' => $request->get('type'),
            'additional_type' => $request->get('additional_type'),
        ]);

        Order::create([
            'id' => $id,
            'customer_id' => $customer->id,
            'type' => 'verbrauchsausweis',
            'status' => 'created',
            'paid' => false,
            'product_id' => $product->id,
            'product_type' => Vbrc::class,
            'meta' => [
                'completed' => ['general']
            ]
        ]);

        return Redirect::route('verbrauch.details', $id);
    }
}
