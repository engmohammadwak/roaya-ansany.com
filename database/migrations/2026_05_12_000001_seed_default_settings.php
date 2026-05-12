<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            'site_name'               => 'مؤسسة رؤيا الإنسانية',
            'site_favicon'            => '/favicon.ico',
            'site_logo'               => '',
            'primary_color'           => '#5a9e2f',
            'secondary_color'         => '#8bc34a',
            'footer_description_ar'   => 'رؤيا هي منصة عطاء مخصصة للأشخاص الذين يهتمون بالأثر الحقيقي لعطائهم.',
            'footer_description_en'   => 'Roaya is a giving platform for those who care about the real impact of their giving.',
            'footer_copyright_ar'     => 'جميع الحقوق محفوظة © مؤسسة رؤيا الإنسانية 2026',
            'footer_copyright_en'     => 'All rights reserved © Roaya Insanya 2026',
            'contact_phone'           => '+905398863777',
            'contact_email'           => 'roaya.ansany@gmail.com',
            'whatsapp_number'         => '+905398863777',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    public function down(): void {}
};
