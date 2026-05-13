<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BlogPage extends Model {
    protected $table = 'blog_page';
    protected $fillable = [
        'hero_title_ar','hero_title_en',
        'hero_desc_ar','hero_desc_en',
        'section_label_ar','section_label_en',
        'section_title_ar','section_title_en',
        'hero_cats_ar','hero_cats_en',
        'hero_sub_ar','hero_sub_en',
        'hero_para_ar','hero_para_en',
        'hero_image','campaign_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * هل المدونة مفعّلة؟
     */
    public static function isEnabled(): bool
    {
        return (bool) static::first()?->is_active ?? true;
    }
}
