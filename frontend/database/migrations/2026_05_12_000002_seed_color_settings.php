<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            // ألوان رئيسية
            'color_primary'        => '#9dcc6b',   // اللون الأخضر — الأزرار والروابط
            'color_secondary'      => '#2F7BC1',   // اللون الأزرق — الغرادينت
            // ألوان النصوص
            'color_text_dark'      => '#272727',   // النص الغامق
            'color_text_muted'     => '#717171',   // النص الرمادي
            'color_text_label'     => '#444C4E',   // نص التسميات
            'color_placeholder'    => '#A9A9A9',   // لون البلسهولدر
            // ألوان الخلفيات
            'color_bg_body'        => '#ffffff',   // خلفية الصفحة
            'color_bg_light'       => '#F5F5F5',   // خلفية فاتحة
            'color_bg_card'        => '#F8F8FA',   // خلفية الكروت
            // ألوان خاصة
            'color_warning'        => '#ff8d02',   // التحذير / برتقالي
            'color_danger'         => '#D9384A',   // الخطر / أحمر
            'color_step_active'    => '#f26b81',   // لون رقم الخطوة النشط
        ];
        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
    public function down(): void {}
};
