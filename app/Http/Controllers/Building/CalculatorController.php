<?php

namespace App\Http\Controllers\Building;

use App\Actions\Product\CalculateCredits;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetCalculatorOldRequest;
use App\Http\Requests\GetCalculatorRequest;
use App\Http\Resources\Building\BuildingResource;
use App\Models\Building;
use Inertia\Inertia;

class CalculatorController extends Controller
{

    const STRATEGY_NEW = 'new';
    const STRATEGY_OLD = 'old';

    public function show(Building $building, GetCalculatorRequest $request)
    {
        $credits = CalculateCredits::run(
            $building,
            kids: $request->validated('customer_kids'),
            salary: $request->validated('customer_salary'),
            has_building: $request->validated('customer_has_building'),
            has_qng: $request->validated('building_has_qng'),
            has_lifecycle: $request->validated('building_has_lifecycle'),
            target: $request->validated('building_target'),
            ecert_rating: $request->validated('building_ecert_rating'),
        );

        return Inertia::render('Hub/Buildings/Calculator/Show', [
            'building' => new BuildingResource($building),
            'credits' => $credits->toArray(),
        ]);
    }


}
