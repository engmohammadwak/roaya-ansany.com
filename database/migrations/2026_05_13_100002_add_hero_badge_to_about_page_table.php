<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_page', function (Blueprint $table) {
            if (!Schema::hasColumn('about_page', 'hero_badge_title_ar')) {
                $table->string('hero_badge_title_ar')->nullable()->after('hero_image_1');
            }
            if (!Schema::hasColumn('about_page', 'hero_badge_title_en')) {
                $table->string('hero_badge_title_en')->nullable()->after('hero_badge_title_ar');
            }
            if (!Schema::hasColumn('about_page', 'hero_badge_subtitle_ar')) {
                $table->string('hero_badge_subtitle_ar')->nullable()->after('hero_badge_title_en');
            }
            if (!Schema::hasColumn('about_page', 'hero_badge_subtitle_en')) {
                $table->string('hero_badge_subtitle_en')->nullable()->after('hero_badge_subtitle_ar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('about_page', function (Blueprint $table) {
            $table->dropColumn([
                'hero_badge_title_ar',
                'hero_badge_title_en',
                'hero_badge_subtitle_ar',
                'hero_badge_subtitle_en',
            ]);
        });
    }
};
