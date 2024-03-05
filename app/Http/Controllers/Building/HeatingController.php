<?php

namespace App\Http\Controllers\Building;

use App\Actions\Building\CreateHeating;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateHeatingRequest;
use App\Models\Building;
use App\Models\Heating;
use Illuminate\Http\RedirectResponse;

class HeatingController extends Controller
{

    public function store(Building $building, CreateHeatingRequest $request): RedirectResponse
    {
        CreateHeating::run(
            building: $building,
            type: $request->validated('type'),
            system: $request->validated('system'),
            constructionYear: $request->validated('construction_year'),
            waterIncluded: $request->validated('water_included'),
            isMain: $request->validated('is_main'),
            comment: $request->validated('comment'),
        );

        return to_route('buildings.energy.show', $building->id);
    }

    public function destroy(Building $building, Heating $heating)
    {
        $heating->delete();

        return to_route('buildings.energy.show', $building->id);
    }

}
