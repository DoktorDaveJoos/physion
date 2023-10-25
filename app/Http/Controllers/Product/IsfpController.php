<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Actions\Product\CreateIsfp;
use App\Http\Requests\CreateIsfpRequest;
use App\Http\Resources\Building\BuildingResource;
use App\Models\Building;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class IsfpController extends Controller
{

    public function show(Building $building)
    {
        return Inertia::render('Hub/Buildings/Isfp/Show', [
            'building' => new BuildingResource($building),
            'can' => [
                'create' => $building->isHouse(),
            ],
        ]);
    }

    public function store(Building $building, CreateIsfpRequest $request)
    {
        $path = $request->file('vollmacht')->store($building->storagePath().'/attachments');

        CreateIsfp::run(
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
            bauantrag_date: $request->get('bauantrag_date'),
            power_of_attorney_path: $path,
        );

        return to_route('buildings.isfp.show', $building->id);
    }


}
