<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TermsOfUse extends Model {
    protected $table = 'terms_of_use';
    protected $fillable = ['title_ar','title_en','content_ar','content_en','last_updated'];
    protected $casts = ['last_updated' => 'datetime'];
}
