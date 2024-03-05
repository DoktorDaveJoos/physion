<?php

namespace App\Http\Controllers\Building;

use App\Actions\Building\CreateAttachment;
use App\Actions\Building\CreateDormer;
use App\Actions\Building\CreateInsulation;
use App\Actions\Building\CreateOrUpdateRoof;
use App\Actions\Building\CreateWindow;
use App\Actions\Building\DestroyAttachment;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAttachmentRequest;
use App\Http\Requests\CreateDormerRequest;
use App\Http\Requests\CreateInsulationRequest;
use App\Http\Requests\CreateOrUpdateRoofRequest;
use App\Http\Requests\CreateWindowRequest;
use App\Http\Resources\Building\BuildingResourceAttachments;
use App\Models\Attachment;
use App\Models\Building;
use App\Models\Dormer;
use App\Models\Insulation;
use App\Models\Roof;
use App\Models\Window;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class RoofController extends Controller
{

    public function update(Building $building, CreateOrUpdateRoofRequest $request): RedirectResponse
    {
        CreateOrUpdateRoof::run(
            building: $building,
            heated: $request->validated('heated'),
            roofShape: $request->validated('roof_shape'),
            construction: $request->validated('construction'),
            uValue: $request->validated('u_value'),
            pitch: $request->validated('pitch'),
            kneeWall: $request->validated('knee_wall'),
            ceiling: $request->validated('ceiling'),
        );

        return to_route('buildings.thermal.show', $building->id);
    }

    public function storeInsulation(Building $building, CreateInsulationRequest $request)
    {
        CreateInsulation::run(
            insulationable: $building->roof,
            type: $request->validated('type'),
            thickness: $request->validated('thickness'),
        );

        return to_route('buildings.thermal.show', $building->id);
    }

    public function destroyInsulation(Building $building, Roof $roof, Insulation $insulation)
    {
        $insulation->delete();

        return to_route('buildings.thermal.show', $building->id);
    }

    public function storeWindow(Building $building, CreateWindowRequest $request)
    {
        CreateWindow::run(
            windowable: $building->roof,
            type: Window::SKYLIGHT,
            count: $request->validated('count'),
            glazing: $request->validated('glazing'),
            height: $request->validated('height'),
            width: $request->validated('width'),
        );

        return to_route('buildings.thermal.show', $building->id);
    }

    public function destroyWindow(Building $building, Roof $roof, Window $window)
    {
        $window->delete();

        return to_route('buildings.thermal.show', $building->id);
    }

    public function storeDormer(Building $building, CreateDormerRequest $request)
    {
        CreateDormer::run(
            roof: $building->roof,
            count: $request->validated('count'),
            form: $request->validated('form'),
            height: $request->validated('height'),
            width: $request->validated('width'),
        );

        return to_route('buildings.thermal.show', $building->id);
    }

    public function destroyDormer(Building $building, Roof $roof, Dormer $dormer)
    {
        $dormer->delete();

        return to_route('buildings.thermal.show', $building->id);
    }
}
