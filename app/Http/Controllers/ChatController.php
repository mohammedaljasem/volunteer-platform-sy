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

    $conversations = $user->conversations()
        ->where('is_archived', false) // 🛠️ هاد الشرط المهم!
        ->with('users')
        ->latest()
        ->get();

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
        $conversation->load('messages.user');
    
        // تسجيل قراءة الرسائل
        foreach ($conversation->messages as $message) {
            $alreadyRead = $message->reads()->where('user_id', auth()->id())->exists();
    
            if (!$alreadyRead) {
                $message->reads()->create([
                    'user_id' => auth()->id(),
                    'read_at' => now(),
                ]);
            }
        }
    
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
public function edit(Conversation $conversation): View
{
    return view('chat.edit', compact('conversation'));
}

public function update(Request $request, Conversation $conversation): RedirectResponse
{
    $request->validate([
        'title' => 'nullable|string|max:255',
    ]);

    $conversation->update([
        'title' => $request->input('title'),
    ]);

    return redirect()->route('chat.index')->with('success', 'تم تعديل اسم المحادثة بنجاح!');
}

public function updateTitle(Request $request, Conversation $conversation): RedirectResponse
{
    // تحقق من صلاحية التعديل (اختياري)
    if (! $conversation->users->contains(auth()->id())) {
        abort(403, 'غير مصرح لك بتعديل هذه المحادثة.');
    }

    $request->validate([
        'title' => 'required|string|max:255',
    ]);

    $conversation->update([
        'title' => $request->input('title'),
    ]);

    return back()->with('success', 'تم تعديل اسم المحادثة بنجاح.');
}
public function destroyConversation(Conversation $conversation): RedirectResponse
{
    if (! $conversation->users->contains(auth()->id())) {
        abort(403, 'غير مصرح لك بحذف هذه المحادثة.');
    }

    // حذف الرسائل والعلاقات ثم المحادثة
    $conversation->messages()->delete();
    $conversation->users()->detach();
    $conversation->delete();

    return back()->with('success', 'تم حذف المحادثة بنجاح.');
}

//الارشفة
public function archiveConversation(Conversation $conversation): RedirectResponse
{
    if (! $conversation->users->contains(auth()->id())) {
        abort(403, 'غير مصرح لك بأرشفة هذه المحادثة.');
    }

    $conversation->update(['is_archived' => true]);

    return back()->with('success', 'تمت أرشفة المحادثة بنجاح.');
}


public function archived()
{
    $user = Auth::user();

    $conversations = $user->conversations()
        ->where('is_archived', true)
        ->with('users')
        ->latest()
        ->get();

    return view('chat.archive', compact('conversations'));
}

public function unarchiveConversation(Conversation $conversation): RedirectResponse
{
    if (! $conversation->users->contains(auth()->id())) {
        abort(403, 'غير مصرح لك باستعادة هذه المحادثة.');
    }

    $conversation->update(['is_archived' => false]);

    return back()->with('success', 'تمت استعادة المحادثة من الأرشيف.');
}





}
