<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Consumption;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ConsumptionController extends Controller
{


    public function store(Building $building, Request $request)
    {
        $request->validate([
            'energy_source' => 'required|string',
            'water_included' => 'required|boolean',
            'start' => 'required|date',
            'end' => 'required|date',
            'consumption' => 'required|numeric',
            'comment' => 'nullable|string',
        ], [
            'energy_source.required' => 'Bitte wählen Sie eine Energiequelle aus.',
            'water_included.required' => 'Bitte wählen Sie aus, ob Wasser in den Nebenkosten enthalten ist.',
            'start.required' => 'Bitte wählen Sie ein Startdatum aus.',
            'end.required' => 'Bitte wählen Sie ein Enddatum aus.',
            'consumption.required' => 'Bitte geben Sie den Verbrauch ein.',
        ]);

        $building->consumptions()->create(
            $request->all() + [
                'period' => floor(
                    CarbonInterval::make(
                        Carbon::parse($request->start)->diff(Carbon::parse($request->end))
                    )->totalMonths
                ),
            ]
        );

        return to_route('hub.buildings.show.consumption', $building->id);
    }

    public function destroy(Building $building, Consumption $consumption)
    {

        $consumption->delete();

        return to_route('hub.buildings.show.consumption', $building->id);
    }


}
