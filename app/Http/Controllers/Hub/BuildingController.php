<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Http\Resources\Building\BuildingResource;
use App\Http\Resources\Building\BuildingResourceEnergieausweis;
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
        return Inertia::render('Hub/Building/Show/BuildingShowIndex', [
            'building' => new BuildingResource($building),
        ]);
    }
    public function showDocs(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingShowDocs', [
            'building' => new BuildingResource($building),
        ]);
    }
    public function showEnergieausweis(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingShowEnergieausweis', [
            'building' => new BuildingResourceEnergieausweis($building),
        ]);
    }
    public function showIsfp(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingDetail', [
            'building' => new BuildingResource($building),
        ]);
    }
    public function showBza(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingDetail', [
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
            'building' => new BuildingResource($building),
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
