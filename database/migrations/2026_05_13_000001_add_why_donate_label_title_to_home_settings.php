<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('home_settings', 'why_donate_label_ar'))
                $table->string('why_donate_label_ar')->nullable()->after('why_cards');
            if (!Schema::hasColumn('home_settings', 'why_donate_label_en'))
                $table->string('why_donate_label_en')->nullable()->after('why_donate_label_ar');
            if (!Schema::hasColumn('home_settings', 'why_donate_title_ar'))
                $table->string('why_donate_title_ar')->nullable()->after('why_donate_label_en');
            if (!Schema::hasColumn('home_settings', 'why_donate_title_en'))
                $table->string('why_donate_title_en')->nullable()->after('why_donate_title_ar');
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn([
                'why_donate_label_ar',
                'why_donate_label_en',
                'why_donate_title_ar',
                'why_donate_title_en',
            ]);
        });
    }
};
