<?php

declare(strict_types=1);

namespace App\Models\Product;

use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;

interface StrategyInterface
{

    public function getAmount(
        array $args
    ): ?array;

    public static function make(Collection $conditions): self;

}

