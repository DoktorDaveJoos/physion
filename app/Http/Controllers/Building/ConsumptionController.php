<?php

namespace App\Http\Controllers\Building;

use App\Actions\Building\CreateConsumption;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateConsumptionRequest;
use App\Http\Resources\Building\BuildingResourceConsumption;
use App\Models\Building;
use App\Models\Consumption;
use Inertia\Inertia;
use Inertia\Response;

class ConsumptionController extends Controller
{

    public function show(Building $building): Response
    {

        $building->load('consumptions');

        return Inertia::render('Hub/Buildings/Consumptions/Show', [
            'building' => BuildingResourceConsumption::make($building),
        ]);
    }

    public function store(Building $building, CreateConsumptionRequest $request)
    {
        CreateConsumption::run(
            building: $building,
            start: $request->validated('start'),
            end: $request->validated('end'),
            consumption: $request->validated('consumption'),
            energySource: $request->validated('energy_source'),
            waterIncluded: $request->validated('water_included'),
            vacancy: $request->validated('vacancy'),
            comment: $request->validated('comment'),
        );

        return to_route('buildings.consumptions.show', $building->id);
    }

    public function destroy(Building $building, Consumption $consumption)
    {

        $consumption->delete();

        return to_route('buildings.consumptions.show', $building->id);
    }
}
