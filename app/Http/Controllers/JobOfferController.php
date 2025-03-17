<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\Organization;
use App\Models\ParticipationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobOfferController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobOffers = JobOffer::with('organization')->latest()->paginate(10);
        return view('job-offers.index', compact('jobOffers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', JobOffer::class);
        
        $organizations = Organization::where('verified', true)->pluck('name', 'id');
        return view('job-offers.create', compact('organizations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', JobOffer::class);
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'organization_id' => 'required|exists:organizations,id',
            'city_id' => 'nullable|exists:cities,id',
            'location_id' => 'nullable|numeric',
            'deadline' => 'required|date|after:today',
            'start_date' => 'nullable|date',
        ]);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('job_offers', 'public');
            $validatedData['image'] = $path;
        }
        
        $validatedData['status'] = 'متاحة';
        
        $jobOffer = JobOffer::create($validatedData);
        
        return redirect()->route('job-offers.show', $jobOffer)
            ->with('success', 'تم إنشاء فرصة التطوع بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobOffer $jobOffer)
    {
        // Check if the user has already requested to participate
        $hasRequested = false;
        if (Auth::check()) {
            $hasRequested = ParticipationRequest::where('user_id', Auth::id())
                ->where('job_offer_id', $jobOffer->id)
                ->exists();
        }
        
        return view('job-offers.show', compact('jobOffer', 'hasRequested'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobOffer $jobOffer)
    {
        $this->authorize('update', $jobOffer);
        
        $organizations = Organization::where('verified', true)->pluck('name', 'id');
        return view('job-offers.edit', compact('jobOffer', 'organizations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobOffer $jobOffer)
    {
        $this->authorize('update', $jobOffer);
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'organization_id' => 'required|exists:organizations,id',
            'city_id' => 'nullable|exists:cities,id',
            'status' => 'required|in:متاحة,مغلقة,قادمة',
            'location_id' => 'nullable|numeric',
            'deadline' => 'required|date',
            'start_date' => 'nullable|date',
        ]);
        
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا وجدت
            if ($jobOffer->image && strpos($jobOffer->image, 'job_offers/') === 0) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($jobOffer->image);
            }
            
            $path = $request->file('image')->store('job_offers', 'public');
            $validatedData['image'] = $path;
        }
        
        $jobOffer->update($validatedData);
        
        return redirect()->route('job-offers.show', $jobOffer)
            ->with('success', 'تم تحديث فرصة التطوع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOffer $jobOffer)
    {
        $this->authorize('delete', $jobOffer);
        
        $jobOffer->delete();
        
        return redirect()->route('job-offers.index')
            ->with('success', 'تم حذف فرصة التطوع بنجاح');
    }

    /**
     * Handle a participation request for a job offer.
     */
    public function requestParticipation(Request $request, JobOffer $jobOffer)
    {
        $this->authorize('request', $jobOffer);
        
        // Check if the user has already requested to participate
        $existing = ParticipationRequest::where('user_id', Auth::id())
            ->where('job_offer_id', $jobOffer->id)
            ->first();
            
        if ($existing) {
            return redirect()->route('job-offers.show', $jobOffer)
                ->with('error', 'لقد قمت بالفعل بطلب المشاركة في هذه الفرصة');
        }
        
        // Create a new participation request
        ParticipationRequest::create([
            'user_id' => Auth::id(),
            'job_offer_id' => $jobOffer->id,
            'status' => 'معلق',
            'request_date' => now(),
        ]);
        
        return redirect()->route('job-offers.show', $jobOffer)
            ->with('success', 'تم تقديم طلب المشاركة بنجاح');
    }
}
