<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Building;
use App\Models\Heating;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateHeating
{

    use asAction;

    public function handle(
        Building $building,
        string $type,
        string $system,
        int $constructionYear,
        bool $waterIncluded,
        bool $isMain,
        ?string $comment,
    ): int {
        Heating::create([
            'building_id' => $building->id,
            'type' => $type,
            'system' => $system,
            'construction_year' => $constructionYear,
            'water_included' => $waterIncluded,
            'is_main' => $isMain,
            'comment' => $comment,
        ]);

        return $building->id;
    }


}
