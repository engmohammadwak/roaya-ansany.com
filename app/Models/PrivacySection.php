<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PrivacySection extends Model {
    protected $fillable = ['privacy_policy_id','title_ar','title_en','body_ar','body_en','sort_order'];
}
