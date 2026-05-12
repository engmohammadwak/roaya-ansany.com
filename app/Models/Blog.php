<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Blog extends Model
{
    protected $fillable = [
        'title_ar', 'title_en',
        'content_ar', 'content_en',
        'excerpt_ar', 'excerpt_en',
        'image', 'slug', 'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // Accessors - يرجع النص حسب اللغة الحالية
    public function getTitleAttribute()
    {
        return App::getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getContentAttribute()
    {
        return App::getLocale() === 'ar' ? $this->content_ar : $this->content_en;
    }

    public function getExcerptAttribute()
    {
        return App::getLocale() === 'ar' ? $this->excerpt_ar : $this->excerpt_en;
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-blog.jpg');
    }
}
