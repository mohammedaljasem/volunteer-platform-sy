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
        'organization_id',
        'status',
        'location_id',
        'deadline',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * علاقة فرصة التطوع بالمنظمة
     * JobOffer belongs to Organization relationship
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
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
