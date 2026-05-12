<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContactPage extends Model {
    protected $table = 'contact_page';
    protected $fillable = [
        'hero_title_ar','hero_title_en',
        'hero_subtitle_ar','hero_subtitle_en',
        'email','phone','fax',
        'work_hours_ar','work_hours_en',
        'whatsapp',
        'address_ar','address_en',
        'facebook','twitter','instagram','youtube',
        'card_text_ar','card_text_en',
        'success_msg_ar','success_msg_en',
        'fail_msg_ar','fail_msg_en',
    ];
}
