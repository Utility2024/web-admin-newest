<?php

namespace App\Policies;

use App\Models\Garment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GarmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isAdminEsd() || $user->isUser() || $user->isManagerAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Garment $garment): bool
    {
        return $user->isSuperAdmin() || $user->isAdminEsd() || $user->isUser() || $user->isManagerAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isAdminEsd();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Garment $garment): bool
    {
        return $user->isSuperAdmin() || $user->isAdminEsd();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Garment $garment): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Garment $garment): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Garment $garment): bool
    {
        return $user->isSuperAdmin();
    }
}
