<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Http\Requests\CreateEcertRequest;
use App\Http\Resources\Building\BuildingResourceEcert;
use App\Models\Building;
use App\Models\EnergyCertificate;
use GuzzleHttp\Promise\Create;
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

    public function store(Building $building, CreateEcertRequest $request)
    {
        EnergyCertificate::create([
            'building_id' => $building->id,
            'type' => $request->type,
            'reason' => $request->reason,
            'suggestion_check' => $request->suggestion_check,
        ]);

        return to_route('buildings.products.ecert.show', $building->id);
    }


}
