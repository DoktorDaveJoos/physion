<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Building;
use App\Models\Cellar;
use App\Models\Wall;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateOrUpdateCellar
{

    use asAction;

    public function handle(
        Building $building,
        ?float $uValue = null,
        ?string $type = null,
        ?int $ceiling = null,
        ?float $height = null,

    ): int {
        Cellar::updateOrCreate(
            ['building_id' => $building->id],
            [
                'u_value' => $uValue,
                'type' => $type,
                'ceiling' => $ceiling,
                'height' => $height,
            ]
        );

        return $building->id;
    }


}
