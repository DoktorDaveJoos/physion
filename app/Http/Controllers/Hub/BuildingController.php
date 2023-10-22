<?php

namespace App\Http\Controllers\Hub;

use App\Actions\Building\CreateBuilding;
use App\Actions\Building\UpdateBuilding;
use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Bdrf\UpdatePositionRequest;
use App\Http\Requests\CreateBuildingRequest;
use App\Http\Requests\CreateBzaRequest;
use App\Http\Requests\CreateIsfpRequest;
use App\Http\Resources\Building\BuildingResource;
use App\Http\Resources\Building\BuildingResourceConsumption;
use App\Http\Resources\Building\BuildingResourceAttachments;
use App\Http\Resources\Building\BuildingResourceEcert;
use App\Http\Resources\Building\BuildingResourcePosition;
use App\Http\Resources\Building\BuildingThermalResource;
use App\Models\Activity;
use App\Models\Attachment;
use App\Models\Building;
use App\Models\Bza;
use App\Models\Customer;
use App\Models\Isfp;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BuildingController extends Controller
{

    public function index()
    {
        return Inertia::render('Hub/Buildings/Index', [
            'buildings' => BuildingResource::collection(
                Building::orderByDesc('created_at')->paginate(10)
            ),
        ]);
    }

    public function show(Building $building)
    {
        return Inertia::render('Hub/Buildings/Show', [
            'building' => new BuildingResource($building),
        ]);
    }

    public function update(Building $building, CreateBuildingRequest $request)
    {
        $buildingId = UpdateBuilding::run(
            building: $building,
            placeId: $request->validated('place_id'),
            street: $request->validated('street'),
            houseNumber: $request->validated('house_number'),
            postalCode: $request->validated('postal_code'),
            city: $request->validated('city'),
            type: $request->validated('type'),
            additionalType: $request->validated('additional_type'),
            constructionYear: $request->validated('construction_year'),
            constructionYearHeating: $request->validated('construction_year_heating'),
            floorArea: $request->validated('floor_area'),
            floors: $request->validated('floors'),
            housingUnits: $request->validated('housing_units'),
            ventilation: $request->validated('ventilation'),
            cellar: $request->validated('cellar'),
            cooling: $request->validated('cooling'),
            coolingCount: $request->validated('cooling_count'),
            coolingService: $request->validated('cooling_service'),
        );

        return to_route('buildings.show', $buildingId);
    }

    public function position(Building $building)
    {
        return Inertia::render('Hub/Buildings/', [
            'building' => new BuildingResourcePosition($building),
        ]);
    }

    public function create()
    {
        return Inertia::render('Hub/Buildings/Create');
    }

    public function store(CreateBuildingRequest $request)
    {
        $buildingId = CreateBuilding::run(
            teamId: $request->user()->currentTeam->id,
            userId: $request->user()->id,
            placeId: $request->validated('place_id'),
            street: $request->validated('street'),
            houseNumber: $request->validated('house_number'),
            postalCode: $request->validated('postal_code'),
            city: $request->validated('city'),
            type: $request->validated('type'),
            additionalType: $request->validated('additional_type'),
            constructionYear: $request->validated('construction_year'),
            constructionYearHeating: $request->validated('construction_year_heating'),
            floorArea: $request->validated('floor_area'),
            floors: $request->validated('floors'),
            housingUnits: $request->validated('housing_units'),
            ventilation: $request->validated('ventilation'),
            cellar: $request->validated('cellar'),
            cooling: $request->validated('cooling'),
            coolingCount: $request->validated('cooling_count'),
            coolingService: $request->validated('cooling_service'),
        );

        return to_route('buildings.position.show', $buildingId);
    }

    public function destroy(Building $building)
    {
        // TODO: Implement destroy() method.
    }


}
