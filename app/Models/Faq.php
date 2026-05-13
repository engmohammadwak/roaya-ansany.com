<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Faq extends Model {
    protected $fillable = ['faq_category_id','question_ar','question_en','answer_ar','answer_en','sort_order','is_active'];

    protected $casts = [
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
    ];

    public function category() { return $this->belongsTo(FaqCategory::class, 'faq_category_id'); }
}
