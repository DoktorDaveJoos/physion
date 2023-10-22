<?php

namespace App\Http\Controllers\Building;

use App\Actions\Building\CreateInsulation;
use App\Actions\Building\CreateOrUpdateWall;
use App\Actions\Building\CreateWindow;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInsulationRequest;
use App\Http\Requests\CreateOrUpdateWallRequest;
use App\Http\Requests\CreateWindowRequest;
use App\Models\Building;
use App\Models\Insulation;
use App\Models\Wall;
use App\Models\Window;
use Illuminate\Http\RedirectResponse;

class WallController extends Controller
{

    public function update(Building $building, CreateOrUpdateWallRequest $request): RedirectResponse
    {
        CreateOrUpdateWall::run(
            building: $building,
            uValue: $request->validated('u_value'),
            construction: $request->validated('construction'),
            variant: $request->validated('variant'),
            thickness: $request->validated('thickness'),
            height: $request->validated('height'),
        );

        return to_route('buildings.thermal.show', $building->id);
    }

    public function storeInsulation(Building $building, CreateInsulationRequest $request)
    {
        CreateInsulation::run(
            insulationable: $building->wall,
            type: $request->validated('type'),
            thickness: $request->validated('thickness'),
        );

        return to_route('buildings.thermal.show', $building->id);
    }

    public function destroyInsulation(Building $building, Wall $wall, Insulation $insulation)
    {
        $insulation->delete();

        return to_route('buildings.thermal.show', $building->id);
    }

    public function storeWindow(Building $building, CreateWindowRequest $request)
    {
        CreateWindow::run(
            windowable: $building->wall,
            type: Window::WINDOW,
            count: $request->validated('count'),
            glazing: $request->validated('glazing'),
            height: $request->validated('height'),
            width: $request->validated('width'),
        );

        return to_route('buildings.thermal.show', $building->id);
    }

    public function destroyWindow(Building $building, Wall $wall, Window $window)
    {
        $window->delete();

        return to_route('buildings.thermal.show', $building->id);
    }
}
