<?php

namespace App\Policies;

use App\Models\User;

class BuildingPolicy
{

    public function create(User $user): bool
    {
        return $user->currentTeam->subscribed();
    }
}
