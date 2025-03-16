<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use App\Models\JobOffer;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // إحصائيات المتطوعين - استخدام مكتبة سباتي للأدوار
        $activeVolunteersCount = User::role('مستخدم')->count();
        
        // إحصائيات الحملات
        $activeCampaignsCount = Ad::where('status', 'active')->count();
        
        // إجمالي التبرعات
        $totalDonations = Donation::sum('amount');
        
        // عدد النشاطات القادمة
        $upcomingActivities = Ad::where('start_date', '>', now())
                               ->where('status', 'upcoming')
                               ->count();
        
        // الحملات الموصى بها - أحدث 3 حملات نشطة
        $recommendedCampaigns = Ad::where('status', 'active')
                                ->orderBy('created_at', 'desc')
                                ->take(3)
                                ->get();
        
        // حساب نسبة التقدم لكل حملة
        foreach ($recommendedCampaigns as $campaign) {
            $campaign->progress_percentage = $campaign->target_amount > 0 
                ? min(round(($campaign->current_amount / $campaign->target_amount) * 100), 100) 
                : 0;
        }
        
        return view('dashboard', compact(
            'activeVolunteersCount',
            'activeCampaignsCount',
            'totalDonations',
            'upcomingActivities',
            'recommendedCampaigns'
        ));
    }
} 