<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;

class VehiclePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isActive();
    }

    public function view(User $user, Vehicle $vehicle): bool
    {
        return $this->hasAccessToVehicle($user, $vehicle);
    }

    public function create(User $user): bool
    {
        return $user->isActive();
    }

    public function update(User $user, Vehicle $vehicle): bool
    {
        return $this->hasAccessToVehicle($user, $vehicle);
    }

    public function delete(User $user, Vehicle $vehicle): bool
    {
        return $this->hasAccessToVehicle($user, $vehicle);
    }

    private function hasAccessToVehicle(User $user, Vehicle $vehicle): bool
    {
        return $user->isActive()
            && (
                $user->isAdmin()
                || $user->isSupervisor()
                || $vehicle->user_id === $user->id
            );
    }
}
