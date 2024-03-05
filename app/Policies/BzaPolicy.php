<?php

namespace App\Policies;

use App\Models\Building;

class BzaPolicy
{

    public function view(Building $building): bool
    {
        return $building->isHouse();
    }

    public function create(Building $building): bool
    {
        return $building->isHouse();
    }
}
