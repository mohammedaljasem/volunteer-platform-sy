<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * عرض صفحة جميع الأحداث
     */
    public function index()
    {
        // الحصول على جميع الحملات التطوعية القادمة
        $upcomingAds = Ad::where('start_date', '>=', now())
            ->with('organization')
            ->orderBy('start_date')
            ->get();
        
        // الحصول على جميع فرص التطوع القادمة
        $upcomingJobOffers = JobOffer::where('start_date', '>=', now())
            ->with('organization')
            ->orderBy('start_date')
            ->get();
        
        return view('events.index', [
            'upcomingAds' => $upcomingAds,
            'upcomingJobOffers' => $upcomingJobOffers,
        ]);
    }
} 