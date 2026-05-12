<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Program extends Model {
    protected $fillable = ['title_ar','title_en','description_ar','description_en','body_ar','body_en','image','category_ar','category_en','icon','is_active','sort_order'];
}
