<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('privacy_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('privacy_policy_id')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->text('body_ar')->nullable();
            $table->text('body_en')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // add hero fields to privacy_policy if missing
        Schema::table('privacy_policy', function (Blueprint $table) {
            if (!Schema::hasColumn('privacy_policy', 'hero_subtitle_ar')) $table->text('hero_subtitle_ar')->nullable();
            if (!Schema::hasColumn('privacy_policy', 'hero_subtitle_en')) $table->text('hero_subtitle_en')->nullable();
        });
    }
    public function down(): void {
        Schema::dropIfExists('privacy_sections');
    }
};
