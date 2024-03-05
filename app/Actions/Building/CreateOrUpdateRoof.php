<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Building;
use App\Models\Roof;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateOrUpdateRoof
{

    use asAction;

    public function handle(
        Building $building,
        ?bool $heated,
        ?string $roofShape,
        ?string $construction,
        ?float $uValue,
        ?int $pitch,
        ?int $kneeWall,
        ?int $ceiling
    ): int {
        Roof::updateOrCreate(
            ['building_id' => $building->id],
            [
                'heated' => $heated,
                'roof_shape' => $roofShape,
                'construction' => $construction,
                'u_value' => $uValue,
                'pitch' => $pitch,
                'knee_wall' => $kneeWall,
                'ceiling' => $ceiling,
            ]
        );

        return $building->id;
    }


}
