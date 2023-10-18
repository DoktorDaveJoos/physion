<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Building;
use App\Models\Renewable;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateRenewable
{

    use asAction;

    public function handle(
        Building $building,
        string $type,
        float $area,
        int $constructionYear,
        bool $electricity,
        bool $heating,
        bool $water,
        string $comment,
    ): int {
        Renewable::create([
            'building_id' => $building->id,
            'type' => $type,
            'area' => $area,
            'construction_year' => $constructionYear,
            'electricity' => $electricity,
            'heating' => $heating,
            'water' => $water,
            'comment' => $comment,
        ]);

        return $building->id;
    }


}
