<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('blogs', function (Blueprint $table) {
            // body fix (may already exist as content_ar/en)
            if (!Schema::hasColumn('blogs', 'body_ar'))  $table->longText('body_ar')->nullable()->after('excerpt_en');
            if (!Schema::hasColumn('blogs', 'body_en'))  $table->longText('body_en')->nullable()->after('body_ar');

            // SEO
            if (!Schema::hasColumn('blogs', 'meta_title_ar'))       $table->string('meta_title_ar')->nullable();
            if (!Schema::hasColumn('blogs', 'meta_title_en'))       $table->string('meta_title_en')->nullable();
            if (!Schema::hasColumn('blogs', 'meta_desc_ar'))        $table->text('meta_desc_ar')->nullable();
            if (!Schema::hasColumn('blogs', 'meta_desc_en'))        $table->text('meta_desc_en')->nullable();
            if (!Schema::hasColumn('blogs', 'og_image'))            $table->string('og_image')->nullable();
            if (!Schema::hasColumn('blogs', 'focus_keyword'))       $table->string('focus_keyword')->nullable();
            if (!Schema::hasColumn('blogs', 'canonical_url'))       $table->string('canonical_url')->nullable();
            if (!Schema::hasColumn('blogs', 'robots'))              $table->string('robots')->default('index, follow');
            if (!Schema::hasColumn('blogs', 'schema_type'))         $table->string('schema_type')->default('Article');
        });
    }
    public function down(): void {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['body_ar','body_en','meta_title_ar','meta_title_en',
                                'meta_desc_ar','meta_desc_en','og_image','focus_keyword',
                                'canonical_url','robots','schema_type']);
        });
    }
};
