<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Building;
use App\Models\Wall;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateOrUpdateWall
{

    use asAction;

    public function handle(
        Building $building,
        ?float $uValue = null,
        ?string $construction = null,
        ?string $variant = null,
        ?int $thickness = null,
        ?float $height = null,
    ): int {
        Wall::updateOrCreate(
            ['building_id' => $building->id],
            [
                'u_value' => $uValue,
                'construction' => $construction,
                'variant' => $variant,
                'thickness' => $thickness,
                'height' => $height,
            ]
        );

        return $building->id;
    }


}
