<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ContactPage extends Model {
    protected $table = 'contact_page';
    protected $fillable = ['hero_title_ar','hero_title_en','hero_subtitle_ar','hero_subtitle_en','email','phone','whatsapp','address_ar','address_en','facebook','twitter','instagram','youtube'];
}
