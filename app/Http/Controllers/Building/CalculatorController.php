<?php

namespace App\Http\Controllers\Building;

use App\Http\Controllers\Controller;
use App\Http\Resources\Building\BuildingResource;
use App\Models\Building;
use Inertia\Inertia;

class CalculatorController extends Controller
{

    public function show(Building $building)
    {
        return Inertia::render('Hub/Buildings/Calculator/Show', [
            'building' => new BuildingResource($building),
        ]);
    }

}
