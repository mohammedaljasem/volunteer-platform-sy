<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOffer extends Model
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
        'requirements',
        'image',
        'organization_id',
        'status',
        'location_id',
        'city_id',
        'deadline',
        'start_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deadline' => 'date',
        'start_date' => 'date',
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
            return 'https://via.placeholder.com/350x200/3949ab/FFFFFF?text=فرصة+تطوع';
        }
        
        // التحقق مما إذا كان المسار يبدأ بـ "job_offers/" وهو مخزن في Storage
        if (strpos($this->image, 'job_offers/') === 0) {
            return asset('storage/' . $this->image);
        }
        
        // إذا كان المسار كاملاً
        return asset($this->image);
    }

    /**
     * علاقة فرصة التطوع بالمنظمة
     * JobOffer belongs to Organization relationship
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * علاقة فرصة التطوع بالمدينة
     * JobOffer belongs to City relationship
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * علاقة فرصة التطوع بطلبات المشاركة
     * JobOffer has many ParticipationRequests relationship
     */
    public function participationRequests(): HasMany
    {
        return $this->hasMany(ParticipationRequest::class);
    }
}
