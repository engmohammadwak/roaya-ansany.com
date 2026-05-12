<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_page', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title_ar')->nullable();
            $table->string('hero_title_en')->nullable();
            $table->text('hero_subtitle_ar')->nullable();
            $table->text('hero_subtitle_en')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('stat1_number')->nullable();
            $table->string('stat1_label_ar')->nullable();
            $table->string('stat1_label_en')->nullable();
            $table->string('stat2_number')->nullable();
            $table->string('stat2_label_ar')->nullable();
            $table->string('stat2_label_en')->nullable();
            $table->string('stat3_number')->nullable();
            $table->string('stat3_label_ar')->nullable();
            $table->string('stat3_label_en')->nullable();
            $table->string('stat4_number')->nullable();
            $table->string('stat4_label_ar')->nullable();
            $table->string('stat4_label_en')->nullable();
            $table->text('mission_ar')->nullable();
            $table->text('mission_en')->nullable();
            $table->text('vision_ar')->nullable();
            $table->text('vision_en')->nullable();
            $table->text('goal_ar')->nullable();
            $table->text('goal_en')->nullable();
            $table->longText('about_text_ar')->nullable();
            $table->longText('about_text_en')->nullable();
            $table->string('about_image')->nullable();
            $table->string('cta_text_ar')->nullable();
            $table->string('cta_text_en')->nullable();
            $table->string('cta_url')->nullable();
            $table->timestamps();
        });

        Schema::create('about_work_fields', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('title_ar');
            $table->string('title_en');
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_work_fields');
        Schema::dropIfExists('about_page');
    }
};
