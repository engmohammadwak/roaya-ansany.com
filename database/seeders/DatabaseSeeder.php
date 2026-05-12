<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default Settings
        $settings = [
            'site_name_ar'        => 'رؤية إنسانية',
            'site_name_en'        => 'Roaya Ansany',
            'site_email'          => 'info@roaya-ansany.com',
            'site_phone'          => '',
            'site_address_ar'     => '',
            'site_address_en'     => '',
            'facebook_url'        => '',
            'twitter_url'         => '',
            'instagram_url'       => '',
            'youtube_url'         => '',
            'hero_title_ar'       => 'رؤية إنسانية',
            'hero_title_en'       => 'Roaya Ansany',
            'hero_subtitle_ar'    => 'معاً نصنع الفرق',
            'hero_subtitle_en'    => 'Together We Make a Difference',
            'about_text_ar'       => '',
            'about_text_en'       => '',
            'logo'                => '',
            'favicon'             => '',
            'privacy_policy_ar'   => '',
            'privacy_policy_en'   => '',
            'terms_ar'            => '',
            'terms_en'            => '',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
