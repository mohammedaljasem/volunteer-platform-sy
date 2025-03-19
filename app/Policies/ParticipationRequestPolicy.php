<?php

namespace App\Policies;

use App\Models\ParticipationRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

class ParticipationRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // السماح للمشرفين بالوصول إلى جميع طلبات المشاركة
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // المستخدم يجب أن يكون مرتبطًا بمنظمة على الأقل
        return DB::table('organization_user')
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ParticipationRequest $participationRequest): bool
    {
        // السماح للمشرفين بمشاهدة أي طلب مشاركة
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // المستخدم يمكنه مشاهدة طلباته الخاصة دائمًا
        if ($participationRequest->user_id === $user->id) {
            return true;
        }
        
        // المستخدم يمكنه مشاهدة طلبات المشاركة في فرص التطوع التي تنتمي لمنظماته
        $jobOffer = $participationRequest->jobOffer;
        if ($jobOffer) {
            $organizationId = $jobOffer->organization_id;
            
            // التحقق مما إذا كان المستخدم مرتبطًا بهذه المنظمة
            return DB::table('organization_user')
                ->where('user_id', $user->id)
                ->where('organization_id', $organizationId)
                ->exists();
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // المستخدمون العاديون يمكنهم إنشاء طلبات مشاركة
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ParticipationRequest $participationRequest): bool
    {
        // السماح للمشرفين بتحديث أي طلب مشاركة
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // فقط صاحب الحملة (منشئ فرصة التطوع) يمكنه تحديث طلبات المشاركة
        $jobOffer = $participationRequest->jobOffer;
        if ($jobOffer) {
            $organizationId = $jobOffer->organization_id;
            
            // التحقق مما إذا كان المستخدم هو منشئ فرصة التطوع (صاحب الحملة)
            return DB::table('job_offers')
                ->where('id', $jobOffer->id)
                ->where('created_by', $user->id)
                ->exists();
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ParticipationRequest $participationRequest): bool
    {
        // السماح للمشرفين بحذف أي طلب مشاركة
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // المستخدم يمكنه حذف طلباته الخاصة فقط إذا كانت معلقة
        if ($participationRequest->user_id === $user->id && $participationRequest->status === 'معلق') {
            return true;
        }
        
        // مدراء المنظمات يمكنهم حذف طلبات المشاركة في فرص التطوع التي تنتمي لمنظماتهم
        $jobOffer = $participationRequest->jobOffer;
        if ($jobOffer) {
            $organizationId = $jobOffer->organization_id;
            
            // التحقق مما إذا كان المستخدم مرتبطًا بهذه المنظمة
            return DB::table('organization_user')
                ->where('user_id', $user->id)
                ->where('organization_id', $organizationId)
                ->exists();
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ParticipationRequest $participationRequest): bool
    {
        // السماح للمشرفين باستعادة أي طلب مشاركة
        if ($user->hasRole('admin')) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ParticipationRequest $participationRequest): bool
    {
        // السماح للمشرفين بالحذف النهائي لأي طلب مشاركة
        if ($user->hasRole('admin')) {
            return true;
        }
        
        return false;
    }
}
