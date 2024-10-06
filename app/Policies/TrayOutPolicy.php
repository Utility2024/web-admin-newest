<?php

namespace App\Policies;

use App\Models\TrayOut;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TrayOutPolicy
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
    public function view(User $user, TrayOut $trayOut): bool
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
    public function update(User $user, TrayOut $trayOut): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh() || $user->isAdminWh();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TrayOut $trayOut): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TrayOut $trayOut): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TrayOut $trayOut): bool
    {
        return $user->isSuperAdmin();
    }
}
