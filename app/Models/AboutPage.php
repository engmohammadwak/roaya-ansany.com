<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $table = 'about_page';

    protected $fillable = [
        'hero_title_ar', 'hero_title_en',
        'hero_subtitle_ar', 'hero_subtitle_en', 'hero_image',
        'stat1_number', 'stat1_label_ar', 'stat1_label_en',
        'stat2_number', 'stat2_label_ar', 'stat2_label_en',
        'stat3_number', 'stat3_label_ar', 'stat3_label_en',
        'stat4_number', 'stat4_label_ar', 'stat4_label_en',
        'mission_ar', 'mission_en',
        'vision_ar', 'vision_en',
        'goal_ar', 'goal_en',
        'about_text_ar', 'about_text_en', 'about_image',
        'cta_text_ar', 'cta_text_en', 'cta_url',
    ];
}
