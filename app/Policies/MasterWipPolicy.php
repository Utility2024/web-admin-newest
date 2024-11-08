<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MasterWip;

class MasterWipPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdminWip() || $user->isUserWip();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MasterWip $masterWip): bool
    {
        return $user->isAdminWip() || $user->isUserWip();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdminWip();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MasterWip $masterWip): bool
    {
        return $user->isAdminWip();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MasterWip $masterWip): bool
    {
        return $user->isAdminWip();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MasterWip $masterWip): bool
    {
        return $user->isAdminWip();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MasterWip $masterWip): bool
    {
        return $user->isSuperAdmin();
    }
}
