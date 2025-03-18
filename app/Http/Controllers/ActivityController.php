<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\JobOffer;
use App\Models\ParticipationRequest;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * عرض صفحة جميع النشاطات
     */
    public function index()
    {
        $user = Auth::user();
        
        // الحصول على جميع الحملات التطوعية التي شارك فيها المستخدم
        $participatedAds = $user->participatedAds()->with('organization')->latest()->get();
        
        // الحصول على جميع فرص التطوع التي شارك فيها المستخدم
        $participationRequests = ParticipationRequest::where('user_id', $user->id)
            ->with(['jobOffer.organization'])
            ->latest()
            ->get();
        
        return view('activities.index', [
            'participatedAds' => $participatedAds,
            'participationRequests' => $participationRequests,
        ]);
    }
} 