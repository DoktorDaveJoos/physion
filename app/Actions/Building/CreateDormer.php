<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Roof;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateDormer
{

    use asAction;

    public function handle(
        Roof $roof,
        int $count,
        string $form,
        int $height,
        int $width,
    ) {
        $roof->dormers()->create([
            'count' => $count,
            'form' => $form,
            'height' => $height,
            'width' => $width,
        ]);
    }
}
