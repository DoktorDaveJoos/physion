<?php

namespace App\Http\Controllers\Building;

use App\Actions\Building\CreateConsumption;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateConsumptionRequest;
use App\Models\Building;
use App\Models\Consumption;
use Inertia\Inertia;
use Inertia\Response;

class ConsumptionController extends Controller
{

    public function show(Building $building): Response
    {
        return Inertia::render('Hub/Building/BuildingConsumption', [
            'building' => $building->load('consumptions'),
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

        return to_route('hub.buildings.show.consumption', $building->id);
    }

    public function destroy(Building $building, Consumption $consumption)
    {

        $consumption->delete();

        return to_route('hub.buildings.show.consumption', $building->id);
    }
}
