<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageRead extends Model
{
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = ['message_id', 'user_id', 'read_at'];

    public $timestamps = false; // ✅ هذا السطر هو المفتاح
}

