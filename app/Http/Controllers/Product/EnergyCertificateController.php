<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Http\Resources\Building\BuildingResourceEnergieausweis;
use App\Models\Building;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class EnergyCertificateController extends Controller
{
    public function show(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingShowEnergieausweis', [
            'building' => new BuildingResourceEnergieausweis($building),
        ]);
    }

    public function store(Building $building)
    {
        // @todo implement

        return to_route('buildings.energieausweis.show', $building->id);
    }


}
