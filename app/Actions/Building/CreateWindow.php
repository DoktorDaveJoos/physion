<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Exceptions\MissingWindowableException;
use App\Models\Cellar;
use App\Models\Roof;
use App\Models\Wall;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateWindow
{

    use asAction;

    /**
     * @throws MissingWindowableException
     */
    public function handle(
        Roof|Wall|Cellar $windowable,
        string $type,
        int $count,
        string $glazing,
        int $height,
        int $width,
    ) {

        if (!$windowable) {
            throw new MissingWindowableException();
        }

        $windowable->windows()->create([
            'type' => $type,
            'count' => $count,
            'glazing' => $glazing,
            'height' => $height,
            'width' => $width,
        ]);

    }


}
