<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\SupportRequest;
use App\Models\SupportTicket;

class SupportController extends Controller
{
    /**
     * إنشاء مثيل جديد من وحدة التحكم.
     */
    public function __construct()
    {
        // تطبيق وسيط التحقق من الدخول على الدوال التي تتطلب تسجيل الدخول
        $this->middleware('auth')->only(['myTickets', 'showTicket', 'replyToTicket']);
    }

    /**
     * عرض صفحة الأسئلة الشائعة
     */
    public function faq()
    {
        return view('support.faq');
    }

    /**
     * عرض صفحة شروط الاستخدام
     */
    public function terms()
    {
        return view('support.terms');
    }

    /**
     * عرض صفحة سياسة الخصوصية
     */
    public function privacy()
    {
        return view('support.privacy');
    }

    /**
     * عرض صفحة الدعم الفني
     */
    public function technical()
    {
        return view('support.technical');
    }

    /**
     * إرسال بريد إلكتروني من نموذج الدعم الفني
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'category' => 'required|in:account,volunteer,donation,technical,other',
            'message' => 'required|string',
        ]);

        // تخزين الرسالة في قاعدة البيانات
        $ticket = new SupportTicket($validated);
        
        // إذا كان المستخدم مسجل دخول، نربط التذكرة به
        if (Auth::check()) {
            $ticket->user_id = Auth::id();
        }
        
        $ticket->save();
        
        // هذا القسم معلق لأنه يتطلب إعداد خدمة البريد الإلكتروني
        /*
        Mail::to('support@volunteer-platform.sy')->send(new SupportRequest($validated));
        */

        return back()->with('success', 'تم إرسال رسالتك بنجاح. سيتم الرد عليك في أقرب وقت ممكن. رقم التذكرة الخاص بك هو #' . $ticket->id);
    }
    
    /**
     * عرض تذاكر الدعم الفني للمستخدم الحالي
     */
    public function myTickets()
    {
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('support.my-tickets', compact('tickets'));
    }
    
    /**
     * عرض تفاصيل تذكرة محددة
     */
    public function showTicket(SupportTicket $ticket)
    {
        // التحقق من أن التذكرة تنتمي للمستخدم الحالي
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بالوصول إلى هذه التذكرة');
        }
        
        return view('support.ticket-show', compact('ticket'));
    }
    
    /**
     * إضافة رد من المستخدم على تذكرة
     */
    public function replyToTicket(Request $request, SupportTicket $ticket)
    {
        // التحقق من أن التذكرة تنتمي للمستخدم الحالي
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بالوصول إلى هذه التذكرة');
        }
        
        // التحقق من أن التذكرة ليست مغلقة
        if ($ticket->status === 'closed') {
            return back()->with('error', 'لا يمكن الرد على تذكرة مغلقة');
        }
        
        $validated = $request->validate([
            'reply' => 'required|string',
        ]);
        
        // تحديث التذكرة بالرد الجديد
        $ticket->status = 'in_progress'; // تغيير الحالة إلى قيد المعالجة
        $ticket->message .= "\n\n----- رد من المستخدم (" . now()->format('Y-m-d H:i') . ") -----\n" . $validated['reply'];
        $ticket->save();
        
        return back()->with('success', 'تم إضافة ردك بنجاح');
    }
}
