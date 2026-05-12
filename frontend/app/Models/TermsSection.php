<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TermsSection extends Model {
    protected $table    = 'terms_sections';
    protected $fillable = ['terms_of_use_id','title_ar','title_en','body_ar','body_en','sort_order'];

    public function terms() {
        return $this->belongsTo(TermsOfUse::class, 'terms_of_use_id');
    }
}
