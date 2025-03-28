<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    //
    public function users()
{
    return $this->belongsToMany(User::class)->withTimestamps()->withPivot('joined_at');
}

public function messages()
{
    return $this->hasMany(Message::class);
}
protected $fillable = ['title', 'is_group', 'is_archived'];


public function show(Conversation $conversation)
{
    // تحميل المستخدمين والرسائل المرتبطة
    $conversation->load(['users', 'messages.user']);

    // التأكد أن المستخدم مشارك بالمحادثة
    if (!$conversation->users->contains(auth()->id())) {
        abort(403, 'ليس لديك صلاحية لعرض هذه المحادثة.');
    }

    return view('chat.show', compact('conversation'));
}



}
