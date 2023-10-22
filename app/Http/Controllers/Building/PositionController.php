<?php

namespace App\Http\Controllers\Building;

use App\Actions\Building\UpdateBuilding;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdatePositionRequest;
use App\Http\Requests\UpdateMapsRequest;
use App\Http\Resources\Building\BuildingResourcePosition;
use App\Models\Building;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class PositionController extends Controller
{

    public function show(Building $building)
    {
        return Inertia::render('Hub/Buildings/Position/Show', [
            'building' => new BuildingResourcePosition($building),
        ]);
    }

    public function update(Building $building, CreateOrUpdatePositionRequest $request): RedirectResponse
    {
        UpdateBuilding::run(
            building: $building,
            layout: $request->validated('layout'),
            sideA: $request->validated('side_a'),
            sideB: $request->validated('side_b'),
            sideC: $request->validated('side_c'),
            sideD: $request->validated('side_d'),
            sideE: $request->validated('side_e'),
            orientation: $request->validated('orientation'),
        );

        return to_route('buildings.thermal.show', $building->id);
    }

    public function updateMaps(Building $building, UpdateMapsRequest $request): RedirectResponse
    {
        UpdateBuilding::run(
            building: $building,
            maps: $request->validated('maps'),
        );

        return to_route('buildings.position.show', $building->id);
    }

}
