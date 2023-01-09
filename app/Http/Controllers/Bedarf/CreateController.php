<?php

namespace App\Http\Controllers\Bedarf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bedarf\CreateRequest;
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
     * @param  CreateRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(CreateRequest $request): RedirectResponse
    {
        $client = new Client();
        $id = $client->generateId(8, Client::MODE_DYNAMIC);

        $customer = Customer::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
        ]);

        $product = Bedarfsausweis::create([
            'street_address' => $request->get('street_address'),
            'zip' => $request->get('zip'),
            'city' => $request->get('city'),
            'type' => $request->get('type'),
            'additional_type' => $request->get('additional_type'),
            'housing_units' => $request->get('housing_units'),
            'construction_year' => $request->get('construction_year'),
        ]);

        Order::create([
            'id' => $id,
            'customer_id' => $customer->id,
            'type' => 'bedarfsausweis',
            'status' => 'created',
            'paid' => false,
            'product_id' => $product->id,
            'product_type' => Bedarfsausweis::class,
        ]);

        return Redirect::route('bedarf.general', $id);
    }
}
