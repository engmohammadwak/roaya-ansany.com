<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutWorkField extends Model
{
    protected $fillable = [
        'icon', 'title_ar', 'title_en',
        'description_ar', 'description_en', 'sort_order',
    ];
}
