<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->string('cta_title_ar')->nullable()->after('donation_currency');
            $table->string('cta_title_en')->nullable()->after('cta_title_ar');
            $table->text('cta_description_ar')->nullable()->after('cta_title_en');
            $table->text('cta_description_en')->nullable()->after('cta_description_ar');
            $table->string('cta_image')->nullable()->after('cta_description_en');
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn([
                'cta_title_ar',
                'cta_title_en',
                'cta_description_ar',
                'cta_description_en',
                'cta_image',
            ]);
        });
    }
};
