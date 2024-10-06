<?php

namespace App\Policies;

use App\Models\MasterRack;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MasterRackPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MasterRack $masterRack): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUserWh();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MasterRack $masterRack): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh() || $user->isAdminWh();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MasterRack $masterRack): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MasterRack $masterRack): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MasterRack $masterRack): bool
    {
        return $user->isSuperAdmin();
    }
}
