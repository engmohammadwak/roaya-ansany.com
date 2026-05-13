<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // حذف كل كاش الإعدادات حتى تظهر التعديلات فوراً
        $keys = [
            'faq_hero_title_ar',
            'faq_hero_title_en',
            'faq_hero_subtitle_ar',
            'faq_hero_subtitle_en',
            'all_settings',
        ];
        foreach ($keys as $key) {
            Cache::forget('setting_' . $key);
            Cache::forget($key);
        }
        Cache::forget('all_settings');
    }

    public function down(): void {}
};
