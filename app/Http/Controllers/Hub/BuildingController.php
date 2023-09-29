<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Http\Resources\Building\BuildingResource;
use App\Http\Resources\Building\BuildingThermalResource;
use App\Models\Building;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BuildingController extends Controller
{

    public function index(Request $request)
    {



        return Inertia::render('Hub/Building/BuildingIndex', [
            'buildings' => BuildingResource::collection(Building::paginate(10)),
        ]);



    }

    public function show(Building $building)
    {

        return Inertia::render('Hub/Building/BuildingDetail', [
            'building' => new BuildingResource($building),
        ]);

    }

    public function thermal(Building $building)
    {
        return Inertia::render('Hub/Building/BuildingThermal', [
            'building' => new BuildingThermalResource($building),
        ]);

    }

    public function energy(Building $building)
    {
        return Inertia::render('Hub/Building/BuildingEnergy', [
            'building' => new BuildingThermalResource($building),
        ]);
    }
    public function create(Request $request)
    {

    }

    public function store(Request $request)
    {

    }

    public function destroy(Building $building)
    {

    }

}
