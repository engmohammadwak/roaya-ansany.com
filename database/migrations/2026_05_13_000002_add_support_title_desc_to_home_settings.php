<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->string('support_title_ar')->nullable()->after('support_image');
            $table->string('support_title_en')->nullable()->after('support_title_ar');
            $table->text('support_description_ar')->nullable()->after('support_title_en');
            $table->text('support_description_en')->nullable()->after('support_description_ar');
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn(['support_title_ar', 'support_title_en', 'support_description_ar', 'support_description_en']);
        });
    }
};
