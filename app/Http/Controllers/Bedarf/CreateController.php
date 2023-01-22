<?php

namespace App\Http\Controllers\Bedarf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bedarf\CreateRequest;
use App\Http\Requests\Verbrauch\CreateOrUpdateRequest;
use App\Models\Bedarfsausweis;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Hidehalo\Nanoid\Client;
use Hidehalo\Nanoid\GeneratorInterface;

class CreateController extends Controller
{
    /**
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

        $product = Bedarfsausweis::create([
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
            'type' => 'bedarfsausweis',
            'status' => 'created',
            'paid' => false,
            'product_id' => $product->id,
            'product_type' => Bedarfsausweis::class,
            'meta' => [
                'completed' => ['general']
            ]
        ]);

        return Redirect::route('bedarf.general', $id);
    }
}
