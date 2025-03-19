<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Donation;
use App\Models\UserPoint;
use App\Models\Wallet;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\DonationThanksNotification;
use Illuminate\Support\Str;

class AdController extends Controller
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
        $query = Ad::with('company');
        
        // تطبيق فلتر البحث
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('company', function($q) use ($searchTerm) {
                      $q->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        // تطبيق فلتر التصنيف
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        // تطبيق فلتر الحالة
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        $ads = $query->latest()->paginate(10)->withQueryString();
        
        return view('ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Ad::class);
        
        $companies = Company::where('verified', true)->pluck('name', 'id');
        return view('ads.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Ad::class);
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'company_id' => 'required|exists:companies,id',
            'category' => 'nullable|string|max:100',
            'goal_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'city_id' => 'nullable|exists:cities,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);
        
        // تنظيف البيانات
        $validatedData['title'] = strip_tags($validatedData['title']);
        $validatedData['description'] = strip_tags($validatedData['description']); // الاكتفاء بإزالة العلامات فقط
        
        if ($request->hasFile('image')) {
            $validatedData['image'] = $this->imageService->storeOptimized(
                $request->file('image'),
                'ads',
                1200, // العرض المطلوب للصورة الرئيسية
                null,
                85
            );
        }
        
        $validatedData['current_amount'] = 0;
        $validatedData['status'] = 'نشطة';
        
        $ad = Ad::create($validatedData);
        
        return redirect()->route('ads.show', $ad)
            ->with('success', 'تم إنشاء الحملة التطوعية بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {
        // استرجاع التعليقات مع معلومات المستخدمين
        $comments = $ad->comments()->with('user')->latest()->get();
        
        return view('ads.show', compact('ad', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ad $ad)
    {
        $this->authorize('update', $ad);
        
        $companies = Company::where('verified', true)->pluck('name', 'id');
        return view('ads.edit', compact('ad', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {
        $this->authorize('update', $ad);
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'company_id' => 'required|exists:companies,id',
            'category' => 'nullable|string|max:100',
            'goal_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:نشطة,مكتملة',
            'city_id' => 'nullable|exists:cities,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);
        
        // تنظيف البيانات
        $validatedData['title'] = strip_tags($validatedData['title']);
        $validatedData['description'] = strip_tags($validatedData['description']); // الاكتفاء بإزالة العلامات فقط
        
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($ad->image) {
                $this->imageService->deleteImage($ad->image);
            }
            
            $validatedData['image'] = $this->imageService->storeOptimized(
                $request->file('image'),
                'ads',
                1200, // العرض المطلوب للصورة الرئيسية
                null,
                85
            );
        }
        
        $ad->update($validatedData);
        
        return redirect()->route('ads.show', $ad)
            ->with('success', 'تم تحديث الحملة التطوعية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        $this->authorize('delete', $ad);
        
        // حذف الصورة المرتبطة بالحملة
        if ($ad->image) {
            $this->imageService->deleteImage($ad->image);
        }
        
        $ad->delete();
        
        return redirect()->route('ads.index')
            ->with('success', 'تم حذف الحملة التطوعية بنجاح');
    }

    /**
     * Show the form for donating to a campaign.
     */
    public function showDonateForm(Ad $ad)
    {
        $this->authorize('donate', $ad);
        
        return view('ads.donate', compact('ad'));
    }

    /**
     * Store a new donation for the campaign.
     */
    public function donate(Request $request, Ad $ad)
    {
        $this->authorize('donate', $ad);
        
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:100',
            'payment_method' => 'required|in:نقدي,تحويل بنكي,محفظة',
            'is_recurring' => 'nullable|boolean',
        ]);
        
        $user = Auth::user();
        $amount = $validatedData['amount'];
        
        // إذا كانت طريقة الدفع هي المحفظة، نتحقق من الرصيد
        if ($validatedData['payment_method'] === 'محفظة') {
            // البحث عن محفظة المستخدم أو إنشاء محفظة جديدة
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0]
            );
            
            // التحقق من كفاية الرصيد
            if ($wallet->balance < $amount) {
                return redirect()->route('ads.donate', $ad)
                    ->with('error', "رصيد محفظتك غير كافٍ. الرصيد الحالي: {$wallet->balance} ليرة سورية")
                    ->withInput();
            }
            
            // خصم المبلغ من المحفظة
            if (!$wallet->withdraw($amount)) {
                return redirect()->route('ads.donate', $ad)
                    ->with('error', 'فشلت عملية السحب من المحفظة، يرجى المحاولة مرة أخرى')
                    ->withInput();
            }
        }
        
        $validatedData['user_id'] = $user->id;
        $validatedData['ad_id'] = $ad->id;
        $validatedData['date'] = now(); // تاريخ اليوم
        $validatedData['is_recurring'] = $request->has('is_recurring');
        
        // إنشاء التبرع
        $donation = Donation::create($validatedData);
        
        // تحديث المبلغ الحالي للحملة
        $ad->current_amount += $amount;
        
        // إذا وصلنا للمبلغ المستهدف أو تجاوزناه، نغير حالة الحملة إلى مكتملة
        if ($ad->current_amount >= $ad->goal_amount) {
            $ad->status = 'مكتملة';
        }
        
        $ad->save();
        
        // منح نقاط للمستخدم (10 نقاط لكل 100 وحدة من المبلغ)
        $pointsToAward = max(10, floor($amount / 100) * 10);
        
        // منح النقاط
        UserPoint::create([
            'user_id' => $user->id,
            'points' => $pointsToAward,
            'earned_date' => now(),
            'source' => 'donation_' . $donation->id,
        ]);
        
        // إرسال إشعار شكر للمستخدم
        $user->notify(new DonationThanksNotification($donation));
        
        return redirect()->route('ads.show', $ad)
            ->with('success', 'تم تسجيل تبرعك بنجاح! شكراً لمساهمتك في هذه الحملة.');
    }

    /**
     * Store a new comment for the campaign.
     */
    public function comment(Request $request, Ad $ad)
    {
        $this->authorize('comment', $ad);
        
        $validatedData = $request->validate([
            'text' => 'required|string|max:500',
        ]);
        
        $validatedData['user_id'] = Auth::id();
        $validatedData['ad_id'] = $ad->id;
        $validatedData['date'] = now(); // تاريخ اليوم
        
        // إنشاء التعليق
        $comment = Comment::create($validatedData);
        
        return redirect()->route('ads.show', $ad)
            ->with('success', 'تم إضافة تعليقك بنجاح!');
    }

    /**
     * Update an existing comment.
     */
    public function updateComment(Request $request, Comment $comment)
    {
        // التأكد من أن المستخدم هو صاحب التعليق
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذا التعليق');
        }
        
        $validatedData = $request->validate([
            'text' => 'required|string|max:500',
        ]);
        
        $comment->update([
            'text' => $validatedData['text'],
        ]);
        
        return redirect()->route('ads.show', $comment->ad_id)
            ->with('success', 'تم تعديل التعليق بنجاح!');
    }
    
    /**
     * Delete a comment.
     */
    public function deleteComment(Comment $comment)
    {
        // التأكد من أن المستخدم هو صاحب التعليق
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بحذف هذا التعليق');
        }
        
        $adId = $comment->ad_id; // حفظ معرف الحملة قبل حذف التعليق
        
        $comment->delete();
        
        return redirect()->route('ads.show', $adId)
            ->with('success', 'تم حذف التعليق بنجاح!');
    }
}
