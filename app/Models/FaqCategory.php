<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class FaqCategory extends Model {
    protected $fillable = ['name_ar','name_en','sort_order'];
    public function faqs() { return $this->hasMany(Faq::class); }
}
