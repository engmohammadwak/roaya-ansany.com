<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

return new class extends Migration {
    public function up(): void
    {
        try {
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
        } catch (\Throwable $e) {
            // cache table may not exist on fresh install — skip
        }
    }

    public function down(): void {}
};
