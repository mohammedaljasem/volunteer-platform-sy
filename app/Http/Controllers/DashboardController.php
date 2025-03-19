<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Donation;
use App\Models\JobOffer;
use App\Models\Organization;
use App\Models\ParticipationRequest;
use App\Models\User;
use App\Models\UserBadge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * عرض لوحة التحكم مع الإحصائيات والبيانات المطلوبة
     */
    public function index()
    {
        $user = Auth::user();
        
        // الإحصائيات العامة
        $activeVolunteersCount = User::count();
        $activeCampaignsCount = Ad::where('status', 'نشطة')->count();
        $totalDonations = Donation::sum('amount');
        $upcomingActivities = JobOffer::where('status', 'قادمة')->count();
        
        // الحملات الموصى بها
        $recommendedCampaigns = Ad::with('organization')
            ->where('status', 'نشطة')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get()
            ->map(function ($campaign) {
                $campaign->progress_percentage = min(100, round(($campaign->current_amount / $campaign->goal_amount) * 100));
                $campaign->target_amount = $campaign->goal_amount;
                return $campaign;
            });
            
        // النشاطات الأخيرة للمستخدم
        $recentActivities = collect();
        
        // طلبات المشاركة الأخيرة
        $latestParticipation = ParticipationRequest::where('user_id', $user->id)
            ->with('jobOffer')
            ->latest()
            ->first();
            
        if ($latestParticipation) {
            $recentActivities->push([
                'type' => 'participation',
                'title' => 'الانضمام إلى فرصة تطوع جديدة',
                'subtitle' => $latestParticipation->jobOffer->title,
                'date' => $latestParticipation->created_at,
                'link' => route('job-offers.index'),
                'color' => 'blue',
                'icon' => 'add'
            ]);
        }
        
        // آخر تبرع
        $latestDonation = Donation::where('user_id', $user->id)
            ->with('ad')
            ->latest()
            ->first();
            
        if ($latestDonation) {
            $recentActivities->push([
                'type' => 'donation',
                'title' => 'التبرع بمبلغ ' . number_format($latestDonation->amount) . ' ل.س',
                'subtitle' => $latestDonation->ad ? 'لحملة ' . $latestDonation->ad->title : 'للمؤسسة',
                'date' => $latestDonation->created_at ?? $latestDonation->date,
                'link' => route('ads.index'),
                'color' => 'green',
                'icon' => 'money'
            ]);
        }
        
        // آخر شارة تم الحصول عليها
        $latestBadge = UserBadge::where('user_id', $user->id)
            ->with('badge')
            ->latest()
            ->first();
            
        if ($latestBadge) {
            $recentActivities->push([
                'type' => 'badge',
                'title' => 'الحصول على شارة متطوع متميز',
                'subtitle' => $latestBadge->badge->name,
                'date' => $latestBadge->created_at,
                'link' => route('profile.edit'),
                'color' => 'yellow',
                'icon' => 'badge'
            ]);
        }
        
        // إضافة نشاط إذا لم يكن هناك أي نشاط
        if ($recentActivities->isEmpty()) {
            $recentActivities->push([
                'type' => 'welcome',
                'title' => 'مرحباً بك في منصة التطوع',
                'subtitle' => 'استكشف الفرص المتاحة وابدأ رحلة العطاء',
                'date' => now(),
                'link' => route('job-offers.index'),
                'color' => 'blue',
                'icon' => 'welcome'
            ]);
        }
        
        $recentActivities = $recentActivities->sortByDesc('date');
        
        return view('dashboard', compact(
            'activeVolunteersCount',
            'activeCampaignsCount',
            'totalDonations',
            'upcomingActivities',
            'recommendedCampaigns',
            'recentActivities'
        ));
    }
} 