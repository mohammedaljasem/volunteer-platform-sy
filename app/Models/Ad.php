<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ad extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'status',
        'company_id',
        'goal_amount',
        'current_amount',
        'start_date',
        'end_date',
        'location_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'goal_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
    ];

    /**
     * علاقة الحملة التطوعية بالشركة أو الفريق التطوعي
     * Ad belongs to a Company relationship
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * علاقة الحملة التطوعية بالتبرعات
     * Ad has many Donations relationship
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * علاقة الحملة التطوعية بالتعليقات
     * Ad has many Comments relationship
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * حساب نسبة الإنجاز للحملة التطوعية
     * Calculate the progress percentage of the campaign
     */
    public function getProgressPercentageAttribute(): float
    {
        if ($this->goal_amount <= 0) {
            return 0;
        }
        
        return min(100, round(($this->current_amount / $this->goal_amount) * 100, 2));
    }
}
