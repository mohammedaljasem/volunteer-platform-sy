<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Organization extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'verified',
        'verification_docs',
        'location_id',
        'contact_email',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'verified' => 'boolean',
    ];

    /**
     * علاقة المنظمة بفرص التطوع
     * Organization has many JobOffers relationship
     */
    public function jobOffers(): HasMany
    {
        return $this->hasMany(JobOffer::class);
    }

    /**
     * علاقة المنظمة بالمستخدمين
     * Organization belongs to many Users relationship
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organization_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * علاقة المنظمة بالموقع
     * Organization has one Location relationship
     */
    public function location(): HasOne
    {
        return $this->hasOne(Location::class);
    }

    /**
     * علاقة المنظمة بالحملات التطوعية
     * Organization has many Ads relationship
     */
    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class, 'company_id');
    }
}
