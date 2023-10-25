<?php

namespace App\Policies;

use App\Models\Building;
use App\Models\User;

class IsfpPolicy
{

    public function view(User $user, Building $building): bool
    {
        ray($building);

        return $building->isHouse();
    }

    public function create(Building $building): bool
    {
        return $building->isHouse();
    }
}
