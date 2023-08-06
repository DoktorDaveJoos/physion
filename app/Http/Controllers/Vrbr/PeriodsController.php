<?php

declare(strict_types=1);

namespace App\Http\Controllers\Vrbr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Vrbr\CreateConsumptionPeriodRequest;
use App\Models\ConsumptionPeriod;
use App\Models\EnergySource;
use App\Models\Vrbr;
use App\Traits\HandleFreeAndPaid;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PeriodsController extends Controller
{

    use HandleFreeAndPaid;

    public function store(CreateConsumptionPeriodRequest $request, Vrbr $vrbr, EnergySource $source): RedirectResponse
    {
        ConsumptionPeriod::create([
            'energy_source_id' => $source->id,
            'start' => $request->get('period')[0],
            'end' => $request->get('period')[1],
            'consumption' => $request->get('consumption'),
            'water' => $request->get('water'),
        ]);

        return self::handleRedirect($request, $vrbr, 'consumption');
    }

    public function destroy(Request $request, Vrbr $vrbr, ConsumptionPeriod $period): RedirectResponse
    {
        $period->delete();

        return self::handleRedirect($request, $vrbr, 'consumption');
    }


}
