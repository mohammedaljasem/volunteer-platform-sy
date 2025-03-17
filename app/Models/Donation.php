<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'ad_id',
        'amount',
        'payment_method',
        'date',
        'is_recurring',
        'is_auto_processed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
        'is_recurring' => 'boolean',
        'is_auto_processed' => 'boolean',
        'amount' => 'decimal:2',
    ];

    /**
     * علاقة التبرع بالمستخدم
     * Donation belongs to a User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة التبرع بالحملة
     * Donation belongs to an Ad (Campaign)
     */
    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
}
