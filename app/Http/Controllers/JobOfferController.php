<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\Organization;
use App\Models\ParticipationRequest;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobOfferController extends Controller
{
    /**
     * خدمة معالجة الصور
     * 
     * @var \App\Services\ImageService
     */
    protected $imageService;

    /**
     * Create a new controller instance.
     */
    public function __construct(ImageService $imageService)
    {
        $this->middleware('auth');
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobOffer::with('organization');
        
        // تطبيق فلتر البحث
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhere('requirements', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('organization', function($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        // تطبيق فلتر التصنيف
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        $jobOffers = $query->latest()->paginate(10)->withQueryString();
        
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
            'organization_id' => 'required|exists:organizations,id',
            'city_id' => 'nullable|exists:cities,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'deadline' => 'required|date|after:today',
            'start_date' => 'nullable|date',
            'status' => 'nullable|in:متاحة,مغلقة,قادمة',
        ]);
        
        // معالجة الصورة إذا تم تقديمها
        if ($request->hasFile('image')) {
            $validatedData['image'] = $this->imageService->storeOptimized(
                $request->file('image'),
                'job-offers',
                800, // العرض المطلوب
                null, // الارتفاع التلقائي
                85 // جودة الصورة
            );
        }
        
        // تعيين الحالة الافتراضية
        if (!isset($validatedData['status'])) {
            $validatedData['status'] = 'متاحة';
        }
        
        // تعيين صاحب الحملة (منشئ فرصة التطوع)
        $validatedData['created_by'] = Auth::id();
        
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'organization_id' => 'required|exists:organizations,id',
            'city_id' => 'nullable|exists:cities,id',
            'status' => 'required|in:متاحة,مغلقة,قادمة',
            'location_id' => 'nullable|numeric',
            'deadline' => 'required|date',
            'start_date' => 'nullable|date',
        ]);
        
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا وجدت
            if ($jobOffer->image) {
                $this->imageService->deleteImage($jobOffer->image);
            }
            
            $validatedData['image'] = $this->imageService->storeOptimized(
                $request->file('image'),
                'job-offers',
                800, // العرض المطلوب
                null, // الارتفاع التلقائي
                85 // جودة الصورة
            );
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
        
        // حذف الصورة المرتبطة بفرصة التطوع
        if ($jobOffer->image) {
            $this->imageService->deleteImage($jobOffer->image);
        }
        
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
