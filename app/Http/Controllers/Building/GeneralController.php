<?php

namespace App\Http\Controllers\Building;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Bdrf\UpdatePositionRequest;
use App\Http\Requests\CreateBuildingRequest;
use App\Http\Requests\CreateBzaRequest;
use App\Http\Requests\CreateIsfpRequest;
use App\Http\Resources\Building\BuildingResource;
use App\Http\Resources\Building\BuildingResourceConsumption;
use App\Http\Resources\Building\BuildingResourceDocs;
use App\Http\Resources\Building\BuildingResourceEnergieausweis;
use App\Http\Resources\Building\BuildingResourcePosition;
use App\Http\Resources\Building\BuildingThermalResource;
use App\Models\Activity;
use App\Models\Attachment;
use App\Models\Building;
use App\Models\Bza;
use App\Models\Customer;
use App\Models\Isfp;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GeneralController extends Controller
{
    public function show(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingShowData', [
            'building' => new BuildingResource($building),
        ]);
    }

}
