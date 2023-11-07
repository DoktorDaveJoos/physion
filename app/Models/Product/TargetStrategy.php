<?php

declare(strict_types=1);

namespace App\Models\Product;

use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;

class TargetStrategy implements StrategyInterface
{

    public function getAmount(array $args): ?array
    {
        // TODO: Implement getAmount() method.

        return null;
    }


    public static function make(Collection $conditions): TargetStrategy
    {
        return new self();
    }
}
