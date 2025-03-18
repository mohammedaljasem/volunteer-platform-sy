<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\ParticipationRequest;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class ParticipationRequestController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the participation requests for organization managers.
     */
    public function index()
    {
        // التحقق من صلاحية المستخدم لعرض قائمة الطلبات
        $this->authorize('viewAny', ParticipationRequest::class);
        
        // الحصول على معرفات المنظمات التي ينتمي إليها المستخدم
        $organizationIds = DB::table('organization_user')
            ->where('user_id', Auth::id())
            ->pluck('organization_id')
            ->toArray();
        
        // إذا كان المستخدم لا ينتمي لأي منظمة، نعرض قائمة فارغة
        if (empty($organizationIds)) {
            $requests = ParticipationRequest::where('id', 0)->paginate(15);
            return view('participation-requests.index', compact('requests'));
        }
        
        // الحصول على معرفات فرص التطوع التي أنشأها المستخدم الحالي فقط
        $jobOfferIds = JobOffer::whereIn('organization_id', $organizationIds)
            ->where('created_by', Auth::id())
            ->pluck('id')
            ->toArray();
        
        // الحصول على طلبات المشاركة التي قدمها المستخدم أو المتعلقة بفرص التطوع التي أنشأها
        $requests = ParticipationRequest::where(function($query) use ($jobOfferIds) {
                $query->whereIn('job_offer_id', $jobOfferIds) // طلبات لفرص تطوع أنشأها المستخدم
                      ->orWhere('user_id', Auth::id()); // أو طلبات قدمها المستخدم نفسه
            })
            ->with(['user', 'jobOffer', 'jobOffer.organization'])
            ->orderBy('request_date', 'desc')
            ->paginate(15);
            
        return view('participation-requests.index', compact('requests'));
    }

    /**
     * Show the details of a specific participation request.
     */
    public function show(ParticipationRequest $participationRequest)
    {
        // التحقق من صلاحية المستخدم لعرض تفاصيل الطلب
        $this->authorize('view', $participationRequest);
        
        return view('participation-requests.show', compact('participationRequest'));
    }

    /**
     * Update the status of a participation request (accept/reject).
     */
    public function updateStatus(Request $request, ParticipationRequest $participationRequest)
    {
        // التحقق من صلاحية المستخدم لتحديث الطلب
        $this->authorize('update', $participationRequest);
        
        $validated = $request->validate([
            'status' => 'required|in:مقبول,مرفوض',
        ]);
        
        $participationRequest->update([
            'status' => $validated['status'],
            'response_date' => now(),
        ]);
        
        return redirect()->route('participation-requests.show', $participationRequest)
            ->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    /**
     * Display a listing of the user's own participation requests.
     */
    public function myRequests()
    {
        $requests = ParticipationRequest::where('user_id', Auth::id())
            ->with(['jobOffer', 'jobOffer.organization'])
            ->orderBy('request_date', 'desc')
            ->paginate(10);
            
        return view('participation-requests.my-requests', compact('requests'));
    }
}
