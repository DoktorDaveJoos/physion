<?php

namespace App\Http\Controllers\Building;

use App\Actions\Building\CreateInsulation;
use App\Actions\Building\CreateOrUpdateCellar;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInsulationRequest;
use App\Http\Requests\CreateOrUpdateCellarRequest;
use App\Models\Building;
use App\Models\Insulation;
use Illuminate\Http\RedirectResponse;

class CellarController extends Controller
{

    public function update(Building $building, CreateOrUpdateCellarRequest $request): RedirectResponse
    {
        CreateOrUpdateCellar::run(
            building: $building,
            uValue: $request->validated('u_value'),
            type: $request->validated('type'),
            ceiling: $request->validated('ceiling'),
            height: $request->validated('height'),
        );

        return to_route('buildings.thermal.show', $building->id);
    }

    public function storeInsulation(Building $building, CreateInsulationRequest $request)
    {
        CreateInsulation::run(
            insulationable: $building->cellarObject,
            type: $request->validated('type'),
            thickness: $request->validated('thickness'),
        );

        return to_route('buildings.thermal.show', $building->id);
    }

    public function destroyInsulation(Building $building, Insulation $insulation)
    {
        $insulation->delete();

        return to_route('buildings.thermal.show', $building->id);
    }
}
