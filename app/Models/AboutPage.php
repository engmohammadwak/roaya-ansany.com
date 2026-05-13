<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $table = 'about_page';

    protected $fillable = [
        // Hero
        'hero_title_ar', 'hero_title_en',
        'hero_description_ar', 'hero_description_en',
        'hero_image_1',

        // Hero Badge (users-rate widget)
        'hero_badge_title_ar', 'hero_badge_title_en',
        'hero_badge_subtitle_ar', 'hero_badge_subtitle_en',

        // Vision section
        'vision_section_desc_ar', 'vision_section_desc_en',

        // Vision card
        'vision_text_ar', 'vision_text_en',

        // Goals card
        'goal_points_ar', 'goal_points_en',

        // Mission card
        'mission_text_ar', 'mission_text_en',

        // Story
        'story_paragraph_1_ar', 'story_paragraph_1_en',
        'story_paragraph_2_ar', 'story_paragraph_2_en',
        'story_cta_text_ar',    'story_cta_text_en',
        'story_image',

        // CTA
        'cta_description_ar', 'cta_description_en',
    ];

    protected $casts = [
        'goal_points_ar' => 'array',
        'goal_points_en' => 'array',
    ];
}
