<?php

namespace App\Policies;

use App\Models\Ionizer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IonizerPolicy
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
    public function view(User $user, Ionizer $ionizer): bool
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
    public function update(User $user, Ionizer $ionizer): bool
    {
        return $user->isSuperAdmin() || $user->isAdminEsd();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ionizer $ionizer): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ionizer $ionizer): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ionizer $ionizer): bool
    {
        return $user->isSuperAdmin();
    }
}
