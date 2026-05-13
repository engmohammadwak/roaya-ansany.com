<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_page', function (Blueprint $table) {
            if (!Schema::hasColumn('blog_page', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('campaign_id');
            }
        });

        // تفعيل المدونة للسجلات الموجودة
        DB::table('blog_page')->whereNull('is_active')->update(['is_active' => true]);
    }

    public function down(): void
    {
        Schema::table('blog_page', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
