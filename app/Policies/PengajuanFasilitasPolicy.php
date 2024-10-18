<?php

namespace App\Policies;

use App\Models\PengajuanFasilitas;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PengajuanFasilitasPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isAdminGa() || $user->isUser() || $user->isUserWh();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PengajuanFasilitas $pengajuanFasilitas): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUser() || $user->isUserWh() || $user->isAdminGa();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUser() || $user->isUserWh() || $user->isAdminGa();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PengajuanFasilitas $pengajuanFasilitas): bool
    {
        return $user->isSuperAdmin() || $user->isSuperAdminWh() || $user->isAdminWh() || $user->isUser() || $user->isUserWh() || $user->isAdminGa();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PengajuanFasilitas $pengajuanFasilitas): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PengajuanFasilitas $pengajuanFasilitas): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PengajuanFasilitas $pengajuanFasilitas): bool
    {
        return $user->isSuperAdmin();
    }
}
