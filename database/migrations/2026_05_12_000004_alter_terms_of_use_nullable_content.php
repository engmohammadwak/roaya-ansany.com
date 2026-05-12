<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('terms_of_use', function (Blueprint $table) {
            $table->text('content_ar')->nullable()->change();
            $table->text('content_en')->nullable()->change();
        });
    }

    public function down(): void {
        Schema::table('terms_of_use', function (Blueprint $table) {
            $table->text('content_ar')->nullable(false)->change();
            $table->text('content_en')->nullable(false)->change();
        });
    }
};
