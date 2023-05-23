<?php

namespace App\Http\Controllers\Verbrauch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Vrbr\CreateConsumptionPeriodRequest;
use App\Models\ConsumptionPeriod;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CreateConsumptionPeriodController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  string  $orderId
     * @param  string  $sourceId
     * @param  CreateConsumptionPeriodRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(
        string $orderId,
        string $sourceId,
        CreateConsumptionPeriodRequest $request
    ): RedirectResponse {
        $periods = ConsumptionPeriod::where('energy_source_id', $sourceId)->get();

        $period = $request->get('period');
        // Check that new period has no overlapping with existing periods
        foreach ($periods as $existingPeriod) {
            if ($existingPeriod->start <= $period[0] && $existingPeriod->end >= $period[0]) {
                return Redirect::route('verbrauch.consumption', $orderId)->withErrors(
                    ['error' => 'Der Zeitraum überschneidet sich mit einem bereits vorhandenen Zeitraum.']
                );
            }
            if ($existingPeriod->start <= $period[1] && $existingPeriod->end >= $period[1]) {
                return Redirect::route('verbrauch.consumption', $orderId)->withErrors(
                    ['error' => 'Der Zeitraum überschneidet sich mit einem bereits vorhandenen Zeitraum.']
                );
            }
            if ($existingPeriod->start >= $period[0] && $existingPeriod->end <= $period[1]) {
                return Redirect::route('verbrauch.consumption', $orderId)->withErrors(
                    ['error' => 'Der Zeitraum überschneidet sich mit einem bereits vorhandenen Zeitraum.']
                );
            }
            if ($existingPeriod->start <= $period[0] && $existingPeriod->end >= $period[1]) {
                return Redirect::route('verbrauch.consumption', $orderId)->withErrors(
                    ['error' => 'Der Zeitraum überschneidet sich mit einem bereits vorhandenen Zeitraum.']
                );
            }
            if ($existingPeriod->start == $period[0] && $existingPeriod->end == $period[1]) {
                return Redirect::route('verbrauch.consumption', $orderId)->withErrors(
                    ['error' => 'Der Zeitraum überschneidet sich mit einem bereits vorhandenen Zeitraum.']
                );
            }
        }


        ConsumptionPeriod::create([
            'energy_source_id' => $sourceId,
            'start' => $period[0],
            'end' => $period[1],
            'consumption' => $request->get('consumption'),
            'water' => $request->get('water'),
        ]);



        return redirect()->route('verbrauch.consumption', $orderId);
    }
}
