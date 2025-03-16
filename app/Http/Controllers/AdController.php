<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
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
        $ads = Ad::with('company')->latest()->paginate(10);
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_id' => 'required|exists:companies,id',
            'goal_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location_id' => 'nullable|numeric',
        ]);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('ads', 'public');
            $validatedData['image'] = $path;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_id' => 'required|exists:companies,id',
            'goal_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:نشطة,مكتملة',
            'location_id' => 'nullable|numeric',
        ]);
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($ad->image) {
                Storage::disk('public')->delete($ad->image);
            }
            
            $path = $request->file('image')->store('ads', 'public');
            $validatedData['image'] = $path;
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
        
        // Delete the image
        if ($ad->image) {
            Storage::disk('public')->delete($ad->image);
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
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:نقدي,تحويل بنكي',
            'is_recurring' => 'nullable|boolean',
        ]);
        
        $validatedData['user_id'] = auth()->id();
        $validatedData['ad_id'] = $ad->id;
        $validatedData['date'] = now(); // تاريخ اليوم
        $validatedData['is_recurring'] = $request->has('is_recurring');
        
        // إنشاء التبرع
        $donation = Donation::create($validatedData);
        
        // تحديث المبلغ الحالي للحملة
        $ad->current_amount += $validatedData['amount'];
        
        // إذا وصلنا للمبلغ المستهدف أو تجاوزناه، نغير حالة الحملة إلى مكتملة
        if ($ad->current_amount >= $ad->goal_amount) {
            $ad->status = 'مكتملة';
        }
        
        $ad->save();
        
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
        
        $validatedData['user_id'] = auth()->id();
        $validatedData['ad_id'] = $ad->id;
        $validatedData['date'] = now(); // تاريخ اليوم
        
        // إنشاء التعليق
        $comment = Comment::create($validatedData);
        
        return redirect()->route('ads.show', $ad)
            ->with('success', 'تم إضافة تعليقك بنجاح!');
    }
}
