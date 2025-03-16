<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'latitude',
        'longitude',
        'city_id',
        'ad_id',
        'company_id',
        'organization_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * علاقة المدينة التي ينتمي لها الموقع
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * علاقة الإعلان المرتبط بهذا الموقع
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class, 'ad_id');
    }

    /**
     * علاقة المنظمة المرتبطة بهذا الموقع
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
