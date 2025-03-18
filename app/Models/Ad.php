<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'category',
        'goal_amount',
        'current_amount',
        'start_date',
        'end_date',
        'city_id',
        'latitude',
        'longitude',
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
     * الحصول على رابط الصورة
     * يعيد صورة افتراضية إذا لم تكن الصورة متوفرة
     * 
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return 'https://via.placeholder.com/350x200/1a237e/FFFFFF?text=حملة+تطوعية';
        }
        
        // التحقق مما إذا كان المسار يبدأ بـ "ads/" وهو مخزن في Storage
        if (strpos($this->image, 'ads/') === 0) {
            return asset('storage/' . $this->image);
        }
        
        // إذا كان المسار كاملاً
        return asset($this->image);
    }

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
     * علاقة الحملة التطوعية بالموقع
     * Ad has one Location relationship
     */
    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'ad_id');
    }

    /**
     * علاقة الحملة التطوعية بالمدينة
     * Ad belongs to City relationship
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * علاقة الحملة التطوعية بالمنظمة
     * Ad belongs to Organization relationship
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
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
