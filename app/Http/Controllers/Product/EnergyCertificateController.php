<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Http\Resources\Building\BuildingResourceEcert;
use App\Models\Building;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class EnergyCertificateController extends Controller
{
    public function show(Building $building)
    {
        return Inertia::render('Hub/Buildings/Ecert/Show', [
            'building' => new BuildingResourceEcert($building),
        ]);
    }

    public function store(Building $building)
    {
        // @todo implement

        return to_route('buildings.energieausweis.show', $building->id);
    }


}
