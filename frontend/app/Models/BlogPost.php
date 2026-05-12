<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BlogPost extends Model {
    protected $fillable = ['title_ar','title_en','slug','excerpt_ar','excerpt_en','body_ar','body_en','image','category_ar','category_en','author','is_published','published_at'];
    protected $casts = ['published_at' => 'datetime', 'is_published' => 'boolean'];
}
