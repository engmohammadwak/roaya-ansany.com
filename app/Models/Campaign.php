<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class Campaign extends Model
{
    protected $fillable = [
        'title_ar', 'title_en', 'slug',
        'description_ar', 'description_en',
        'image', 'target_amount',
        'collected_amount', 'end_date', 'is_active'
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'target_amount'    => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'end_date'         => 'date',
    ];

    // =====================
    // Route Model Binding
    // =====================
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // =====================
    // Auto-generate slug
    // =====================
    protected static function booted(): void
    {
        static::saving(function (Campaign $campaign) {
            if (empty($campaign->slug)) {
                $base = $campaign->title_en ?? $campaign->title_ar ?? 'campaign';
                $slug = Str::slug($base);
                $original = $slug;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '!=', $campaign->id ?? 0)->exists()) {
                    $slug = $original . '-' . $i++;
                }
                $campaign->slug = $slug;
            }
        });
    }

    // =====================
    // Scopes
    // =====================
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // =====================
    // Accessors
    // =====================
    public function getTitleAttribute()
    {
        return App::getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getDescriptionAttribute()
    {
        return App::getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount <= 0) return 0;
        return min(100, round(($this->collected_amount / $this->target_amount) * 100));
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-campaign.jpg');
    }

    public function getCampaignUrlAttribute()
    {
        $locale = App::getLocale();
        return url($locale . '/campaigns/' . ($this->slug ?? $this->id));
    }
}
