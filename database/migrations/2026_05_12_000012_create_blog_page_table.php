<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('blog_page', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title_ar')->nullable();
            $table->string('hero_title_en')->nullable();
            $table->text('hero_desc_ar')->nullable();
            $table->text('hero_desc_en')->nullable();
            $table->string('section_label_ar')->nullable()->default('مدوّنات رؤيا');
            $table->string('section_label_en')->nullable()->default('Roaya Blog');
            $table->string('section_title_ar')->nullable()->default('رؤيا: حكايات تصنع اللحظة');
            $table->string('section_title_en')->nullable()->default('Roaya: Stories that Make the Moment');
            // hero categories (comma-separated or JSON)
            $table->string('hero_cats_ar')->nullable()->default('حكاية,حياة,كرم');
            $table->string('hero_cats_en')->nullable()->default('Story,Life,Generosity');
            $table->string('hero_sub_ar')->nullable()->default('غيّر حياة شخص اليوم بتبرعك');
            $table->string('hero_sub_en')->nullable()->default('Change a life today with your donation');
            $table->text('hero_para_ar')->nullable();
            $table->text('hero_para_en')->nullable();
            $table->timestamps();
        });

        // add missing cols to blog posts if needed
        Schema::table('blog_posts', function (Blueprint $table) {
            if (!Schema::hasColumn('blog_posts', 'published_at')) {
                $table->timestamp('published_at')->nullable();
            }
        });
    }
    public function down(): void {
        Schema::dropIfExists('blog_page');
    }
};
