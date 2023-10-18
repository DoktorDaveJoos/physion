<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Building;
use App\Models\Consumption;
use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateConsumption
{

    use asAction;

    public function handle(
        Building $building,
        string $start,
        string $end,
        string $energySource,
        bool $waterIncluded,
        float $consumption,
        int $vacancy,
        string $comment
    ) {

        $period = floor(
            CarbonInterval::make(
                Carbon::parse($start)->diff(Carbon::parse($end))
            )->totalMonths
        );

        $consumption = Consumption::create([
            'building_id' => $building->id,
            'start' => $start,
            'end' => $end,
            'period' => $period,
            'energy_source' => $energySource,
            'water_included' => $waterIncluded,
            'consumption' => $consumption,
            'vacancy' => $vacancy,
            'comment' => $comment,
        ]);

        return $consumption->id;
    }


}
