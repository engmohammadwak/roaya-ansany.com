<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // أضف عمودي العنوان لـ terms_of_use إذا ما كانوا موجودين
        if (Schema::hasTable('terms_of_use')) {
            Schema::table('terms_of_use', function (Blueprint $t) {
                if (!Schema::hasColumn('terms_of_use', 'banner_title_ar')) {
                    $t->string('banner_title_ar')->nullable()->after('title_ar');
                }
                if (!Schema::hasColumn('terms_of_use', 'banner_title_en')) {
                    $t->string('banner_title_en')->nullable()->after('title_en');
                }
                if (!Schema::hasColumn('terms_of_use', 'banner_desc_ar')) {
                    $t->text('banner_desc_ar')->nullable()->after('banner_title_ar');
                }
                if (!Schema::hasColumn('terms_of_use', 'banner_desc_en')) {
                    $t->text('banner_desc_en')->nullable()->after('banner_title_en');
                }
            });
        }

        // جدول البنود
        if (!Schema::hasTable('terms_sections')) {
            Schema::create('terms_sections', function (Blueprint $t) {
                $t->id();
                $t->foreignId('terms_of_use_id')->constrained('terms_of_use')->onDelete('cascade');
                $t->string('title_ar');
                $t->string('title_en')->nullable();
                $t->text('body_ar');
                $t->text('body_en')->nullable();
                $t->unsignedSmallInteger('sort_order')->default(0);
                $t->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('terms_sections');
    }
};
