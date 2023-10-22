<?php

namespace App\Http\Controllers\Building;

use App\Http\Controllers\Controller;
use App\Http\Resources\Building\BuildingResource;
use App\Jobs\CreateExposePredictionsJob;
use App\Models\Building;
use Inertia\Inertia;

class ExposeController extends Controller
{

    public function show(Building $building)
    {
        return Inertia::render('Hub/Buildings/Expose/Show', [
            'building' => new BuildingResource($building),
            'generating' => cache()->has('building_expose_' . $building->id),
        ]);
    }

    public function store(Building $building)
    {
        cache()->put('building_expose_' . $building->id, true, 3600);

        CreateExposePredictionsJob::dispatch($building->id);

        return to_route('buildings.expose.show', $building->id);
    }

}
