<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->string('hero_label_top')->nullable()->default('12px')->after('hero_label_en');
            $table->string('hero_label_left')->nullable()->default('0')->after('hero_label_top');
            $table->string('hero_label_right')->nullable()->default('0')->after('hero_label_left');
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn(['hero_label_top', 'hero_label_left', 'hero_label_right']);
        });
    }
};
