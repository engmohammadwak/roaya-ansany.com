<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Project extends Model {
    protected $fillable = ['title_ar','title_en','description_ar','description_en','body_ar','body_en','image','country_ar','country_en','category_ar','category_en','goal_amount','raised_amount','is_active','sort_order'];
    public function getPercentAttribute() {
        if ($this->goal_amount <= 0) return 0;
        return min(100, round(($this->raised_amount / $this->goal_amount) * 100));
    }
}
