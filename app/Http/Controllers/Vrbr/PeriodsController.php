<?php

declare(strict_types=1);

namespace App\Http\Controllers\Vrbr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Vrbr\CreateConsumptionPeriodRequest;
use App\Models\ConsumptionPeriod;
use App\Models\EnergySource;
use App\Models\Vrbr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PeriodsController extends Controller
{

    public function store(CreateConsumptionPeriodRequest $request, Vrbr $vrbr, EnergySource $source): RedirectResponse
    {

        ConsumptionPeriod::create([
            'energy_source_id' => $source->id,
            'start' => $request->get('period')[0],
            'end' => $request->get('period')[1],
            'consumption' => $request->get('consumption'),
            'water' => $request->get('water'),
        ]);

        return to_route('certificate.show', [
            'order' => $vrbr->order,
            'page' => 'consumption',
            'signature' => $request->get('signature')
        ]);

    }

    public function destroy(Request $request, Vrbr $vrbr, ConsumptionPeriod $period): RedirectResponse
    {
        $request->validate([
            'signature' => 'required|string',
        ]);

        $period->delete();

        return to_route('certificate.show', [
            'order' => $vrbr->order,
            'page' => 'consumption',
            'signature' => $request->get('signature')
        ]);
    }


}
