<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Exceptions\MissingWindoweableException;
use App\Models\Cellar;
use App\Models\Roof;
use App\Models\Wall;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateWindow
{

    use asAction;

    /**
     * @throws MissingWindoweableException
     */
    public function handle(
        Roof|Wall|Cellar $windoweable,
        string $type,
        int $count,
        string $glazing,
        int $height,
        int $width,
    ) {

        if (!$windoweable) {
            throw new MissingWindoweableException();
        }

        $windoweable->windows()->create([
            'type' => $type,
            'count' => $count,
            'glazing' => $glazing,
            'height' => $height,
            'width' => $width,
        ]);

    }


}
