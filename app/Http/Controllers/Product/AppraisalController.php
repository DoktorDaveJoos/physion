<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Http\Resources\Building\BuildingResource;
use App\Models\Building;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class AppraisalController extends Controller
{
    public function show(Building $building)
    {
        return Inertia::render('Hub/Building/BuildingAppraisal', [
            'building' => BuildingResource::make($building),
        ]);
    }
}
