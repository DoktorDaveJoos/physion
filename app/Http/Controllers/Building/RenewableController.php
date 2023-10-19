<?php

namespace App\Http\Controllers\Building;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Insulation;
use App\Models\Window;
use Illuminate\Http\RedirectResponse;

class RenewableController extends Controller
{

    public function update(Building $building): RedirectResponse
    {
        // @todo implement

        return to_route('buildings.thermal.show', $building->id);
    }

    public function storeInsulation(Building $building)
    {
        // @todo implement

        return to_route('buildings.thermal.show', $building->id);
    }

    public function destroyInsulation(Building $building, Insulation $insulation)
    {
        $insulation->delete();

        return to_route('buildings.thermal.show', $building->id);
    }

    public function storeWindow(Building $building)
    {
        // @todo implement

        return to_route('buildings.thermal.show', $building->id);
    }

    public function destroyWindow(Building $building, Window $window)
    {
        $window->delete();

        return to_route('buildings.thermal.show', $building->id);
    }
}
