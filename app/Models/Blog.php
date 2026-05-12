<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title_ar','title_en','slug',
        'excerpt_ar','excerpt_en',
        'body_ar','body_en',
        'image','is_published','published_at',
        // SEO
        'meta_title_ar','meta_title_en',
        'meta_desc_ar','meta_desc_en',
        'og_image','focus_keyword',
        'canonical_url','robots','schema_type',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    // =====================
    // Auto-generate slug
    // =====================
    protected static function booted(): void {
        static::saving(function (Blog $blog) {
            if (empty($blog->slug)) {
                $base = $blog->title_ar ?? $blog->title_en ?? 'blog';
                $slug = Str::slug($base);
                if (empty($slug)) $slug = 'blog-' . time();
                $original = $slug;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '!=', $blog->id ?? 0)->exists()) {
                    $slug = $original . '-' . $i++;
                }
                $blog->slug = $slug;
            }
        });
    }

    // =====================
    // Scopes
    // =====================
    public function scopePublished($query) {
        return $query->where('is_published', true);
    }

    // =====================
    // Accessors
    // =====================
    public function getTitleAttribute() {
        $locale = App::getLocale();
        return $locale === 'ar' ? $this->title_ar : ($this->title_en ?: $this->title_ar);
    }

    public function getBodyAttribute() {
        $locale = App::getLocale();
        return $locale === 'ar' ? $this->body_ar : ($this->body_en ?: $this->body_ar);
    }

    public function getExcerptAttribute() {
        $locale = App::getLocale();
        return $locale === 'ar' ? $this->excerpt_ar : ($this->excerpt_en ?: $this->excerpt_ar);
    }

    public function getMetaTitleAttribute() {
        $locale = App::getLocale();
        $mt = $locale === 'ar' ? $this->meta_title_ar : ($this->meta_title_en ?: $this->meta_title_ar);
        return $mt ?: $this->title;
    }

    public function getMetaDescAttribute() {
        $locale = App::getLocale();
        $md = $locale === 'ar' ? $this->meta_desc_ar : ($this->meta_desc_en ?: $this->meta_desc_ar);
        return $md ?: Str::limit(strip_tags($this->body ?? ''), 160);
    }

    public function getOgImageUrlAttribute() {
        if ($this->og_image) return asset('storage/'.$this->og_image);
        if ($this->image)    return asset('storage/'.$this->image);
        return asset('website/images/og-default.jpg');
    }

    public function getCanonicalAttribute() {
        if ($this->canonical_url) return $this->canonical_url;
        $locale = App::getLocale();
        return url($locale.'/blogs/'.$this->slug);
    }

    public function getImageUrlAttribute() {
        return $this->image ? asset('storage/'.$this->image) : null;
    }
}
