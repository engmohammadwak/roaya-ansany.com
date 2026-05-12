<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (Schema::hasTable('blogs')) {
            // Table already exists — just add missing columns
            Schema::table('blogs', function (Blueprint $table) {
                if (!Schema::hasColumn('blogs', 'title_ar'))      $table->string('title_ar')->nullable();
                if (!Schema::hasColumn('blogs', 'title_en'))      $table->string('title_en')->nullable();
                if (!Schema::hasColumn('blogs', 'slug'))          $table->string('slug')->nullable()->unique();
                if (!Schema::hasColumn('blogs', 'excerpt_ar'))    $table->text('excerpt_ar')->nullable();
                if (!Schema::hasColumn('blogs', 'excerpt_en'))    $table->text('excerpt_en')->nullable();
                if (!Schema::hasColumn('blogs', 'body_ar'))       $table->longText('body_ar')->nullable();
                if (!Schema::hasColumn('blogs', 'body_en'))       $table->longText('body_en')->nullable();
                if (!Schema::hasColumn('blogs', 'image'))         $table->string('image')->nullable();
                if (!Schema::hasColumn('blogs', 'is_published'))  $table->boolean('is_published')->default(true);
                if (!Schema::hasColumn('blogs', 'published_at'))  $table->timestamp('published_at')->nullable();
                if (!Schema::hasColumn('blogs', 'meta_title_ar')) $table->string('meta_title_ar')->nullable();
                if (!Schema::hasColumn('blogs', 'meta_title_en')) $table->string('meta_title_en')->nullable();
                if (!Schema::hasColumn('blogs', 'meta_desc_ar'))  $table->text('meta_desc_ar')->nullable();
                if (!Schema::hasColumn('blogs', 'meta_desc_en'))  $table->text('meta_desc_en')->nullable();
                if (!Schema::hasColumn('blogs', 'og_image'))      $table->string('og_image')->nullable();
                if (!Schema::hasColumn('blogs', 'focus_keyword')) $table->string('focus_keyword')->nullable();
                if (!Schema::hasColumn('blogs', 'canonical_url')) $table->string('canonical_url')->nullable();
                if (!Schema::hasColumn('blogs', 'robots'))        $table->string('robots')->default('index, follow');
                if (!Schema::hasColumn('blogs', 'schema_type'))   $table->string('schema_type')->default('BlogPosting');
            });
            return;
        }

        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->text('excerpt_ar')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->longText('body_ar')->nullable();
            $table->longText('body_en')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            // SEO
            $table->string('meta_title_ar')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_desc_ar')->nullable();
            $table->text('meta_desc_en')->nullable();
            $table->string('og_image')->nullable();
            $table->string('focus_keyword')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('robots')->default('index, follow');
            $table->string('schema_type')->default('BlogPosting');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('blogs');
    }
};
