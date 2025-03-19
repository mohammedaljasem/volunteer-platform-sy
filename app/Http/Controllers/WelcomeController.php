<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ad;
use App\Models\JobOffer;
use App\Models\ParticipationRequest;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function index()
    {
        // استخدام التخزين المؤقت للإحصائيات
        $stats = Cache::remember('home_stats', 3600, function () {
            return [
                'activeUsersCount' => User::whereHas('roles', function($query) {
                    $query->where('name', 'مستخدم');
                })->count(),
                'campaignsCount' => Ad::where('status', 'نشطة')->count(),
                'totalDonations' => Ad::sum('current_amount'),
                'citiesCount' => DB::table('cities')->count(),
            ];
        });

        // جلب 3 حملات مميزة مع eager loading للعلاقات
        $featuredCampaigns = Cache::remember('featured_campaigns', 1800, function () {
            return Ad::with(['company', 'city'])
                ->where('status', 'نشطة')
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
        });

        // جلب فرص تطوع متاحة مع eager loading للعلاقات
        $jobOffers = Cache::remember('latest_job_offers', 1800, function () {
            return JobOffer::with(['organization', 'city'])
                ->where('status', 'متاحة')
                ->orderBy('created_at', 'desc')
                ->take(2)
                ->get();
        });

        return view('welcome', compact(
            'stats', 
            'featuredCampaigns', 
            'jobOffers'
        ));
    }
}
