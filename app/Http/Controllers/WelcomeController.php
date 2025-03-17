<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ad;
use App\Models\JobOffer;
use App\Models\ParticipationRequest;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        // جلب إحصائيات المتطوعين
        $activeUsersCount = User::whereHas('roles', function($query) {
            $query->where('name', 'مستخدم');
        })->count();

        // جلب إحصائيات الحملات التطوعية
        $campaignsCount = Ad::where('status', 'نشطة')->count();

        // حساب إجمالي التبرعات
        $totalDonations = Ad::sum('current_amount');

        // عدد المحافظات (يمكن استبداله بحساب حقيقي)
        $citiesCount = DB::table('cities')->count();

        // جلب 3 حملات مميزة (الأحدث أو الأكثر تبرعاً)
        $featuredCampaigns = Ad::where('status', 'نشطة')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // جلب فرص تطوع متاحة
        $jobOffers = JobOffer::where('status', 'متاحة')
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        return view('welcome', compact(
            'activeUsersCount', 
            'campaignsCount', 
            'totalDonations', 
            'citiesCount',
            'featuredCampaigns',
            'jobOffers'
        ));
    }
}
