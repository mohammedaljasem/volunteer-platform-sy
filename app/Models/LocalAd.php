<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocalAd extends Model
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
        'status', // نشط، معلق، مرفوض
        'user_id',
        'city_id',
        'expires_at',
        'category',
        'contact_info',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * علاقة الإعلان المحلي بالمستخدم
     * LocalAd belongs to a User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة الإعلان المحلي بالمدينة
     * LocalAd belongs to a City
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * الحصول على رابط الصورة
     * Get the image URL
     * 
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return 'https://via.placeholder.com/350x200/003366/FFFFFF?text=إعلان+محلي';
        }
        
        if (strpos($this->image, 'local-ads/') === 0) {
            return asset('storage/' . $this->image);
        }
        
        return asset($this->image);
    }
} 