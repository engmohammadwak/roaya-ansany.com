<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $fillable = [
        // Hero
        'hero_title_ar', 'hero_title_en',
        'hero_description_ar', 'hero_description_en',
        'hero_label_ar', 'hero_label_en',
        'hero_label_top', 'hero_label_left', 'hero_label_right',
        'hero_image',
        // Campaign Banner
        'cb_title_ar', 'cb_title_en',
        'cb_subtitle_ar', 'cb_subtitle_en',
        'cb_description_ar', 'cb_description_en',
        'cb_image',
        // Why Donate
        'why_cards',
        // Stats
        'stats_title_ar', 'stats_title_en',
        'stats_image',
        // About / Where We Work
        'about_title_ar', 'about_title_en',
        'about_description_ar', 'about_description_en',
        'about_image',
        // Support
        'support_image',
        'support_items',
        // FAQ
        'faqs',
        // Newsletter
        'newsletter_title_ar', 'newsletter_title_en',
        'newsletter_description_ar', 'newsletter_description_en',
        // Donation Counter
        'donation_goal',
        'donation_raised',
        'donation_currency',
    ];

    protected $casts = [
        'why_cards'     => 'array',
        'support_items' => 'array',
        'faqs'          => 'array',
        'donation_goal'   => 'float',
        'donation_raised' => 'float',
    ];

    // Always work with single row (id=1)
    public static function instance(): self
    {
        return self::firstOrCreate(['id' => 1]);
    }
}
