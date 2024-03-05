<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Cellar;
use App\Models\Roof;
use App\Models\Wall;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateInsulation
{

    use asAction;

    public function handle(
        Roof|Wall|Cellar $insulationable,
        string $type,
        int $thickness,
    ) {
        $insulationable->insulations()->create([
            'type' => $type,
            'thickness' => $thickness,
        ]);
    }


}
