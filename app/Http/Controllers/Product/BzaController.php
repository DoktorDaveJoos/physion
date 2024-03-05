<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Actions\Product\CreateBza;
use App\Http\Requests\CreateBzaRequest;
use App\Http\Resources\Building\BuildingResource;
use App\Models\Building;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class BzaController extends Controller
{
    public function show(Building $building)
    {
        return Inertia::render('Hub/Buildings/Bza/Show', [
            'building' => new BuildingResource($building),
            'can' => [
                'create' => $building->isHouse(),
            ],
        ]);
    }

    public function store(Building $building, CreateBzaRequest $request)
    {
        $path = $request->file('vollmacht')->store($building->storagePath().'/attachments');

        CreateBza::run(
            building: $building,
            type: $request->get('type'),
            title: $request->get('title'),
            first_name: $request->get('first_name'),
            last_name: $request->get('last_name'),
            street: $request->get('street'),
            house_number: $request->get('house_number'),
            postal_code: $request->get('postal_code'),
            city: $request->get('city'),
            country: $request->get('country'),
            phone: $request->get('phone'),
            email: $request->get('email'),
            power_of_attorney_path: $path,
        );

        return to_route('hub.products.buildings.bza', [
            'building' => $building->id,
        ]);
    }

}
