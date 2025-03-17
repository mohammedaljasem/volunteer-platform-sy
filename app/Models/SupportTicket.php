<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportTicket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'subject',
        'category',
        'message',
        'status',
        'reply',
        'user_id',
    ];

    /**
     * العلاقة مع المستخدم الذي أنشأ تذكرة الدعم (إذا كان مسجلاً)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * الحصول على اسم التصنيف بالعربية
     */
    public function getCategoryNameAttribute(): string
    {
        return [
            'account' => 'مشكلة في الحساب',
            'volunteer' => 'مشكلة في التطوع',
            'donation' => 'مشكلة في التبرع',
            'technical' => 'مشكلة فنية',
            'other' => 'أخرى',
        ][$this->category] ?? $this->category;
    }

    /**
     * الحصول على اسم الحالة بالعربية
     */
    public function getStatusNameAttribute(): string
    {
        return [
            'new' => 'جديدة',
            'in_progress' => 'قيد المعالجة',
            'resolved' => 'تم الحل',
            'closed' => 'مغلقة',
        ][$this->status] ?? $this->status;
    }
}
