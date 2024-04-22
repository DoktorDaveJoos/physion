<?php

namespace App\Http\Controllers\Hub;

use App\Actions\Building\CreateBuilding;
use App\Actions\Building\UpdateBuilding;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBuildingRequest;
use App\Http\Resources\Building\BuildingResource;
use App\Http\Resources\Building\BuildingResourcePosition;
use App\Models\Building;
use Inertia\Inertia;

class BuildingController extends Controller
{

    public function index()
    {
        return Inertia::render('Hub/Buildings/Index', [
            'buildings' => BuildingResource::collection(
                auth()->user()->currentTeam->buildings()->orderByDesc('created_at')->paginate(10)
                // Building::query()->orderByDesc('created_at')->paginate(10)
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
            newBuilding: $request->validated('new_building'),
            street: $request->validated('street'),
            houseNumber: $request->validated('house_number'),
            postalCode: $request->validated('postal_code'),
            city: $request->validated('city'),
            type: $request->validated('type'),
            additionalType: $request->validated('additional_type'),
            constructionYear: $request->validated('construction_year'),
            floorArea: $request->validated('floor_area'),
            landArea: $request->validated('land_area'),
            floors: $request->validated('floors'),
            floor: $request->validated('floor'),
            rooms: $request->validated('rooms'),
            housingUnits: $request->validated('housing_units'),
            ventilation: $request->validated('ventilation'),
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
