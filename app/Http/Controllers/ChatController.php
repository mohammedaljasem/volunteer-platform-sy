<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;




class ChatController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $conversations = $user->conversations()->with('users')->latest()->get();

        return view('chat.index', compact('conversations'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'nullable|string|max:255',
        ]);

        $authUser = auth()->user();

        // إنشاء المحادثة
        $conversation = \App\Models\Conversation::create([
            'title' => $request->input('title'),
            'is_group' => false,
        ]);

        // ربط المستخدمين بالمحادثة
        $conversation->users()->attach([
            $authUser->id => ['joined_at' => now()],
            $request->user_id => ['joined_at' => now()],
        ]);

        return redirect()->route('chat.index')->with('success', 'تم إنشاء المحادثة!');
    }



public function show(Conversation $conversation): View
{
    // بإمكانك تحميل الرسائل مثلاً لو بدك
    $conversation->load('messages.user');

    return view('chat.show', compact('conversation'));
}



public function storeMessage(Request $request, Conversation $conversation)
{
    $request->validate([
        'body' => 'required|string|max:1000',
    ]);

    $conversation->messages()->create([
        'user_id' => auth()->id(),
        'content' => $request->input('body'), // هذا هو التعديل المطلوب
    ]);

    return redirect()->route('chat.show', $conversation)->with('success', 'تم إرسال الرسالة');
}

public function destroyMessage(Message $message): RedirectResponse
{
    // تحقق إذا المستخدم يملك الرسالة
    if ($message->user_id !== auth()->id()) {
        abort(403);
    }

    $message->delete();

    return back()->with('success', 'تم حذف الرسالة بنجاح.');
}


public function destroy(Message $message): RedirectResponse
{
    if ($message->user_id !== auth()->id()) {
        abort(403, 'غير مصرح لك بحذف هذه الرسالة.');
    }

    $message->delete();

    return back()->with('success', 'تم حذف الرسالة بنجاح.');
}






}
