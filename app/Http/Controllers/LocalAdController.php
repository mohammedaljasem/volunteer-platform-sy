<?php

namespace App\Http\Controllers;

use App\Models\LocalAd;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LocalAdController extends Controller
{
    /**
     * Constructor to set middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * عرض قائمة الإعلانات المحلية
     * Display a listing of local ads.
     */
    public function index()
    {
        $localAds = LocalAd::with(['user', 'city'])
            ->where('status', 'نشط')
            ->latest()
            ->paginate(10);
        
        return view('local-ads.index', compact('localAds'));
    }

    /**
     * عرض نموذج إنشاء إعلان محلي جديد
     * Show the form for creating a new local ad.
     */
    public function create()
    {
        $cities = City::all();
        return view('local-ads.create', compact('cities'));
    }

    /**
     * تخزين إعلان محلي جديد
     * Store a newly created local ad.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'contact_info' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:100',
        ]);
        
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'معلق'; // الإعلانات المحلية تبدأ كمعلقة حتى يتم الموافقة عليها
        $validated['expires_at'] = now()->addDays(30); // تنتهي بعد 30 يوم افتراضياً
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('local-ads', 'public');
            $validated['image'] = $path;
        }
        
        LocalAd::create($validated);
        
        return redirect()->route('local-ads.index')
            ->with('success', 'تم إرسال الإعلان المحلي للمراجعة والموافقة');
    }

    /**
     * عرض إعلان محلي
     * Display the specified local ad.
     */
    public function show(LocalAd $localAd)
    {
        return view('local-ads.show', compact('localAd'));
    }

    /**
     * عرض نموذج تعديل إعلان محلي
     * Show the form for editing the specified local ad.
     */
    public function edit(LocalAd $localAd)
    {
        // التحقق من أن المستخدم هو صاحب الإعلان
        if (Auth::id() !== $localAd->user_id) {
            abort(403, 'غير مصرح لك بتعديل هذا الإعلان');
        }
        
        $cities = City::all();
        return view('local-ads.edit', compact('localAd', 'cities'));
    }

    /**
     * تحديث إعلان محلي
     * Update the specified local ad.
     */
    public function update(Request $request, LocalAd $localAd)
    {
        // التحقق من أن المستخدم هو صاحب الإعلان
        if (Auth::id() !== $localAd->user_id) {
            abort(403, 'غير مصرح لك بتعديل هذا الإعلان');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'contact_info' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:100',
        ]);
        
        // إعادة تعيين الحالة إلى معلق بعد التعديل
        $validated['status'] = 'معلق';
        
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا وجدت
            if ($localAd->image) {
                Storage::disk('public')->delete($localAd->image);
            }
            
            $path = $request->file('image')->store('local-ads', 'public');
            $validated['image'] = $path;
        }
        
        $localAd->update($validated);
        
        return redirect()->route('local-ads.show', $localAd)
            ->with('success', 'تم تحديث الإعلان المحلي بنجاح');
    }

    /**
     * حذف إعلان محلي
     * Remove the specified local ad.
     */
    public function destroy(LocalAd $localAd)
    {
        // التحقق من أن المستخدم هو صاحب الإعلان
        if (Auth::id() !== $localAd->user_id) {
            abort(403, 'غير مصرح لك بحذف هذا الإعلان');
        }
        
        // حذف الصورة المرتبطة بالإعلان
        if ($localAd->image) {
            Storage::disk('public')->delete($localAd->image);
        }
        
        $localAd->delete();
        
        return redirect()->route('local-ads.index')
            ->with('success', 'تم حذف الإعلان المحلي بنجاح');
    }
} 