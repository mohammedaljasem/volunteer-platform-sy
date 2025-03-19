<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Ad;
use App\Models\Badge;
use App\Models\Donation;
use App\Models\JobOffer;
use App\Models\UserBadge;
use App\Models\ParticipationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    /**
     * عرض نشاطات المستخدم
     */
    public function index()
    {
        $user = Auth::user();
        
        // طلبات المشاركة
        $participationRequests = ParticipationRequest::with('jobOffer.organization')
            ->where('user_id', $user->id)
            ->latest()
            ->get();
        
        // الحملات المشارك بها - استخدام العلاقة المعرفة في نموذج User
        $participatedAds = $user->participatedAds()->with('organization')->latest()->get();
            
        // التبرعات
        $donations = Donation::where('user_id', $user->id)
            ->with('ad')
            ->latest()
            ->get();
            
        // الشارات
        $badges = UserBadge::where('user_id', $user->id)
            ->with('badge')
            ->latest()
            ->get();
        
        // تجميع كل النشاطات الحديثة مع معلومات إضافية
        $recentActivities = new Collection();
        
        // إضافة طلبات المشاركة
        foreach ($participationRequests as $request) {
            $recentActivities->push([
                'title' => 'طلب الانضمام إلى ' . $request->jobOffer->title,
                'date' => $request->created_at,
                'link' => route('job-offers.show', $request->jobOffer),
                'icon' => 'add',
                'color' => 'blue',
                'type' => 'participation'
            ]);
        }
        
        // إضافة الحملات المشارك بها
        foreach ($participatedAds as $ad) {
            $recentActivities->push([
                'title' => 'المشاركة في حملة ' . $ad->title,
                'date' => $ad->pivot->created_at,
                'link' => route('ads.show', $ad),
                'icon' => 'add',
                'color' => 'blue',
                'type' => 'ad'
            ]);
        }
        
        // إضافة التبرعات
        foreach ($donations as $donation) {
            $title = 'تبرع بمبلغ ' . number_format($donation->amount) . ' ل.س';
            if ($donation->ad) {
                $title .= ' لحملة ' . $donation->ad->title;
            }
            
            $recentActivities->push([
                'title' => $title,
                'date' => $donation->created_at,
                'link' => $donation->ad ? route('ads.show', $donation->ad) : route('profile.edit'),
                'icon' => 'money',
                'color' => 'green',
                'type' => 'donation'
            ]);
        }
        
        // إضافة الشارات
        foreach ($badges as $userBadge) {
            $recentActivities->push([
                'title' => 'الحصول على شارة ' . $userBadge->badge->name,
                'date' => $userBadge->created_at,
                'link' => route('profile.edit'),
                'icon' => 'badge',
                'color' => 'yellow',
                'type' => 'badge'
            ]);
        }
        
        // ترتيب النشاطات حسب التاريخ والحد الأقصى 10 نشاطات
        $recentActivities = $recentActivities->sortByDesc('date')->take(10);
        
        return view('activities.index', compact(
            'participationRequests', 
            'participatedAds', 
            'donations', 
            'badges', 
            'recentActivities'
        ));
    }
} 