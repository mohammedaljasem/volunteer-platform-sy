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
        // مسح التخزين المؤقت للإحصائيات لضمان تحديث البيانات
        Cache::forget('home_stats');
        
        // استخدام التخزين المؤقت للإحصائيات
        $stats = Cache::remember('home_stats', 3600, function () {
            // الحصول على إجمالي عدد طلبات المشاركة المقبولة
            $acceptedRequests = ParticipationRequest::where('status', 'مقبول')->count();
            
            return [
                // عدد المتطوعين النشطين
                'volunteersCount' => User::whereHas('roles', function($query) {
                    $query->where('name', 'مستخدم');
                })->count(),
                
                // عدد المنظمات المسجلة
                'organizationsCount' => Organization::count(),
                
                // عدد الحملات التطوعية
                'campaignsCount' => Ad::where('status', 'نشطة')->count(),
                
                // إجمالي ساعات التطوع (تقدير بضرب عدد الطلبات المقبولة في 5 ساعات افتراضية)
                'volunteerHours' => $acceptedRequests * 5, // افتراض أن كل مشاركة تستغرق 5 ساعات
                
                // إحصائيات إضافية
                'totalDonations' => Ad::sum('current_amount'),
                'pendingRequests' => ParticipationRequest::where('status', 'معلق')->count(),
                'citiesCount' => DB::table('cities')->count(),
            ];
        });

        // مسح التخزين المؤقت للحملات وفرص العمل
        Cache::forget('featured_campaigns');
        Cache::forget('latest_job_offers');

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

        // التأكد من أن جميع المتغيرات موجودة قبل عرض الصفحة
        if (!isset($stats) || !is_array($stats)) {
            $stats = [
                'volunteersCount' => 0,
                'organizationsCount' => 0,
                'campaignsCount' => 0,
                'volunteerHours' => 0,
                'totalDonations' => 0,
                'pendingRequests' => 0,
                'citiesCount' => 0
            ];
        }

        return view('welcome', compact(
            'stats', 
            'featuredCampaigns', 
            'jobOffers'
        ));
    }
}
