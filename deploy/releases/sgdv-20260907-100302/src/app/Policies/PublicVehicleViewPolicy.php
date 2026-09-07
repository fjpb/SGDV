<?php

namespace App\Policies;

use App\Models\PublicVehicleView;
use App\Models\User;

class PublicVehicleViewPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->isAdminOrSupervisor($user);
    }

    private function isAdminOrSupervisor(User $user): bool
    {
        return $user->isActive()
            && ($user->isAdmin() || $user->isSupervisor());
    }
}
