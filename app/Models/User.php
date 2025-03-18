<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'notification_preference',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be appended to arrays.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the URL of the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }
        
        return asset('images/default-avatar.svg');
    }

    /**
     * علاقة المستخدم بالتبرعات
     * User has many Donations relationship
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * علاقة المستخدم بالتعليقات
     * User has many Comments relationship
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * علاقة المستخدم بطلبات المشاركة
     * User has many ParticipationRequests relationship
     */
    public function participationRequests(): HasMany
    {
        return $this->hasMany(ParticipationRequest::class);
    }

    /**
     * علاقة المستخدم بالمنظمات
     * User belongs to many Organizations relationship
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'organization_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * علاقة المستخدم بالشارات
     * User belongs to many Badges relationship
     */
    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('date')
            ->withTimestamps();
    }

    /**
     * علاقة المستخدم بالنقاط
     * User has many UserPoints relationship
     */
    public function points(): HasMany
    {
        return $this->hasMany(UserPoint::class);
    }

    /**
     * علاقة المستخدم بالإشعارات
     * User has many Notifications relationship
     */
    public function customNotifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * حساب إجمالي نقاط المستخدم
     *
     * @return int
     */
    public function getTotalPointsAttribute(): int
    {
        return $this->points()->sum('points');
    }

    /**
     * علاقة المستخدم بالمحفظة
     * User has one Wallet relationship
     */
    public function wallet()
    {
        return $this->hasOne(\App\Models\Wallet::class);
    }

    /**
     * الحصول على محفظة المستخدم أو إنشاء محفظة جديدة
     */
    public function getWalletAttribute()
    {
        $wallet = $this->wallet()->first();
        
        if (!$wallet) {
            $wallet = \App\Models\Wallet::create([
                'user_id' => $this->id,
                'balance' => 0
            ]);
        }
        
        return $wallet;
    }

    /**
     * علاقة المستخدم بالحملات التي شارك فيها
     * User participated in Ads relationship
     */
    public function participatedAds(): BelongsToMany
    {
        return $this->belongsToMany(Ad::class, 'ad_participants')
            ->withTimestamps();
    }
}
