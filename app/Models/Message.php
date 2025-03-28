<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    public function conversation()
{
    return $this->belongsTo(Conversation::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}


protected $fillable = ['conversation_id', 'user_id', 'content', 'is_read'];

public function reads()
{
    return $this->hasMany(MessageRead::class);
}



}
