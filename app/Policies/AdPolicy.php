<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        // Super admin can do everything
        if ($user->hasRole('admin')) {
            return true;
        }
        
        return null; // fall through to other authorization checks
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Anyone can view the campaigns
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ad $ad): bool
    {
        // Anyone can view individual campaigns
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only users with 'create-campaign' permission can create campaigns
        return $user->hasPermissionTo('create-campaign');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ad $ad): bool
    {
        // Only users with 'edit-campaign' permission and who belong to the company can update
        return $user->hasPermissionTo('edit-campaign') && 
            ($user->company_id == $ad->company_id || $user->hasRole('منظمة'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ad $ad): bool
    {
        // Only users with 'delete-campaign' permission and who belong to the company can delete
        return $user->hasPermissionTo('delete-campaign') && 
            ($user->company_id == $ad->company_id || $user->hasRole('منظمة'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ad $ad): bool
    {
        // Only organization or team that created the campaign can restore it
        return $user->hasPermissionTo('edit-campaign') && 
            ($user->company_id == $ad->company_id || $user->hasRole('منظمة'));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ad $ad): bool
    {
        // Only organizations can permanently delete campaigns
        return $user->hasRole('منظمة');
    }

    /**
     * Determine whether the user can donate to the model.
     */
    public function donate(User $user, Ad $ad): bool
    {
        // جميع المستخدمين المسجلين يمكنهم التبرع للحملات
        return true;
    }

    /**
     * Determine whether the user can comment on the model.
     */
    public function comment(User $user, Ad $ad): bool
    {
        // جميع المستخدمين المسجلين يمكنهم التعليق على الحملات
        return true;
    }
}
