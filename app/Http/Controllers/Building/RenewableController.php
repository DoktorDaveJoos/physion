<?php

namespace App\Http\Controllers\Building;

use App\Actions\Building\CreateRenewable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRenewableRequest;
use App\Models\Building;
use App\Models\Renewable;
use Illuminate\Http\RedirectResponse;

class RenewableController extends Controller
{

    public function store(Building $building, CreateRenewableRequest $request): RedirectResponse
    {
        CreateRenewable::run(
            building: $building,
            type: $request->validated('type'),
            area: $request->validated('area'),
            constructionYear: $request->validated('construction_year'),
            electricity: $request->validated('electricity'),
            heating: $request->validated('heating'),
            water: $request->validated('water'),
            comment: $request->validated('comment'),
        );

        return to_route('buildings.energy.show', $building->id);
    }

    public function destroy(Building $building, Renewable $renewable)
    {
        $renewable->delete();

        return to_route('buildings.energy.show', $building->id);
    }

}
