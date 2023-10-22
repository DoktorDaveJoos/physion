<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Http\Requests\CreateIsfpRequest;
use App\Http\Resources\Building\BuildingResource;
use App\Models\Activity;
use App\Models\Building;
use App\Models\Customer;
use App\Models\Isfp;
use App\Models\Product;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class IsfpController extends Controller
{

    public function show(Building $building)
    {
        return Inertia::render('Hub/Buildings/Isfp/Show', [
            'building' => new BuildingResource($building),
        ]);
    }

    public function store(Building $building, CreateIsfpRequest $request)
    {

        $isfpProduct = Product::where('short_name', 'isfp')->firstOrFail();

        $path = $request->file('vollmacht')->store($building->storagePath().'/attachments');

        $customer = Customer::create([
            'type' => $request->get('type'),
            'title' => $request->get('title'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'address_line_1' => $request->get('street').' '.$request->get('house_number'),
            'zip' => $request->get('postal_code'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
        ]);

        $building->update([
            'bauantrag_date' => $request->get('bauantrag_date'),
        ]);

        Isfp::create([
            'building_id' => $building->id,
            'customer_id' => $customer->id,
            'product_id' => $isfpProduct->id,
            'power_of_attorney_path' => $path,
        ]);

        return to_route('buildings.isfp.show', $building->id);
    }



}
