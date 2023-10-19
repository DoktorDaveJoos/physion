<?php

namespace App\Http\Controllers\Building;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Insulation;
use App\Models\Window;
use Illuminate\Http\RedirectResponse;

class PositionController extends Controller
{

    public function update(Building $building): RedirectResponse
    {
        // @todo implement

        return to_route('buildings.thermal.show', $building->id);
    }

    public function updateMaps(Building $building): RedirectResponse
    {
        // @todo implement

        return to_route('buildings.thermal.show', $building->id);
    }

}
