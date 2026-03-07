<?php

namespace App\Policies;

use App\Models\Institution;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Policy for Institution resource authorization.
 * 
 * Permissions:
 * - super_admin: Can view and edit
 * - admin: Can view only
 * - professor: No access
 * - student: No access
 */
class InstitutionPolicy
{
    /**
     * Determine whether the user can view any institutions.
     * Only super_admin and admin can view.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']);
    }

    /**
     * Determine whether the user can view the institution.
     * Only super_admin and admin can view.
     */
    public function view(User $user, Institution $institution): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']);
    }

    /**
     * Determine whether the user can create institutions.
     * Prevented: only one institution should exist.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the institution.
     * Only super_admin can edit institution settings.
     */
    public function update(User $user, Institution $institution): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can delete the institution.
     * Prevented: institution should not be deleted.
     */
    public function delete(User $user, Institution $institution): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the institution.
     */
    public function restore(User $user, Institution $institution): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the institution.
     */
    public function forceDelete(User $user, Institution $institution): bool
    {
        return false;
    }
}
