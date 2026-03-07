<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Activitylog\Models\Activity;

/**
 * ActivityPolicy
 * 
 * Authorization policy for Activity Log (audit trail).
 * 
 * Permission Levels:
 * - super_admin: Can view all activity logs
 * - admin, professor, student: No access (activity logs are sensitive)
 * - Nobody can create, update, or delete activity logs (system-generated only)
 * 
 * @package App\Policies
 */
class ActivityPolicy
{
    /**
     * Determine whether the user can view any activity logs.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can view a specific activity log.
     */
    public function view(User $user, Activity $activity): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Nobody can create activity logs (system-generated only).
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Nobody can update activity logs (immutable audit trail).
     */
    public function update(User $user, Activity $activity): bool
    {
        return false;
    }

    /**
     * Nobody can delete activity logs (permanent audit trail).
     */
    public function delete(User $user, Activity $activity): bool
    {
        return false;
    }

    /**
     * Nobody can restore activity logs.
     */
    public function restore(User $user, Activity $activity): bool
    {
        return false;
    }

    /**
     * Nobody can permanently delete activity logs.
     */
    public function forceDelete(User $user, Activity $activity): bool
    {
        return false;
    }
}
