<?php

namespace App\Http\Controllers\Hub;

use App\Actions\Building\CreateBuilding;
use App\Actions\Building\UpdateBuilding;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBuildingRequest;
use App\Http\Resources\Building\BuildingResource;
use App\Http\Resources\Building\BuildingResourcePosition;
use App\Http\Resources\Building\OrderResource;
use App\Models\Building;
use App\Models\EnergyCertificate;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class OrderController extends Controller
{

    public function index(): RedirectResponse
    {
        ray('HEY');
        return to_route('orders.ecert.index');
    }

    public function indexEcert()
    {

        ray('HEY THERE');

        return Inertia::render('Hub/Order/Ecert/Index', [
            'orders' => EnergyCertificate::all(),
        ]);
    }

    public function indexIsfp()
    {
        return Inertia::render('Hub/Buildings/IndexEcert', [
            'orders' => EnergyCertificate::all(),
        ]);
    }

    public function indexBza()
    {
        return Inertia::render('Hub/Buildings/IndexEcert', [
            'orders' => EnergyCertificate::all(),
        ]);
    }

    public function show(Building $building)
    {
        return Inertia::render('Hub/Buildings/Show', [
            'building' => new BuildingResource($building),
        ]);
    }

}
