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
        'amount',
        'user_id',
        'ad_id',
        'date',
        'is_recurring',
        'payment_method',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'is_recurring' => 'boolean',
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
