<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Campaign extends Model
{
    protected $fillable = [
        'title_ar', 'title_en',
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

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

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
}
