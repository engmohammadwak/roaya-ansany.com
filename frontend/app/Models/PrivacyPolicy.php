<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model {
    protected $table = 'privacy_policy';
    protected $fillable = [
        'title_ar','title_en',
        'hero_subtitle_ar','hero_subtitle_en',
        'content_ar','content_en',
        'last_updated',
    ];
    protected $casts = ['last_updated' => 'datetime'];

    public function sections() {
        return $this->hasMany(PrivacySection::class)->orderBy('sort_order');
    }
}
