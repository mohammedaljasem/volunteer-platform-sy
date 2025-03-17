<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    /**
     * عرض قائمة المشتركين في النشرة البريدية (للمشرفين فقط)
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('viewNewsletterSubscribers');
        
        $subscribers = Newsletter::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.newsletters.index', compact('subscribers'));
    }

    /**
     * معالجة طلب الاشتراك في النشرة البريدية
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {
        // التحقق من صحة البريد الإلكتروني
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletters,email'
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح',
            'email.unique' => 'هذا البريد الإلكتروني مشترك مسبقاً في النشرة البريدية'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // إنشاء اشتراك جديد
        Newsletter::create([
            'email' => $request->email,
            'subscribed_at' => now()
        ]);

        return redirect()->back()->with('success', 'تم الاشتراك في النشرة البريدية بنجاح.');
    }

    /**
     * إلغاء الاشتراك في النشرة البريدية
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe($email)
    {
        $newsletter = Newsletter::where('email', $email)->first();

        if ($newsletter) {
            $newsletter->update(['is_active' => false]);
            return redirect()->route('home')->with('success', 'تم إلغاء اشتراكك من النشرة البريدية بنجاح.');
        }

        return redirect()->route('home')->with('error', 'لم يتم العثور على هذا البريد الإلكتروني في قائمة المشتركين.');
    }
    
    /**
     * حذف مشترك من النشرة البريدية (للمشرفين فقط)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('deleteNewsletterSubscribers');
        
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();
        
        return redirect()->route('admin.newsletters.index')
            ->with('success', 'تم حذف المشترك من النشرة البريدية بنجاح.');
    }
}
