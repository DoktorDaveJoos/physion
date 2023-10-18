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
        float $uValue,
        string $construction,
        string $variant,
        int $thickness,
        int $height,
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
