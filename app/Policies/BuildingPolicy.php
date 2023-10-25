<?php

namespace App\Policies;

use App\Models\Building;
use App\Models\User;

class BuildingPolicy
{

    public function viewIsfp(User $user, Building $building): bool
    {
        ray($building);

        return $building->isHouse();
    }

    public function create(User $user): bool
    {
        return $user->currentTeam->subscribed();
    }
}
