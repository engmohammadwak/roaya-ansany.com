<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('paymob_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('paymob_settings', 'secret_key'))   $table->text('secret_key')->nullable()->after('id');
            if (!Schema::hasColumn('paymob_settings', 'public_key'))   $table->string('public_key')->nullable()->after('secret_key');
            if (!Schema::hasColumn('paymob_settings', 'callback_url')) $table->string('callback_url')->nullable();
            if (!Schema::hasColumn('paymob_settings', 'redirect_url')) $table->string('redirect_url')->nullable();
            // Remove old api_key if exists
            if (Schema::hasColumn('paymob_settings', 'api_key'))       $table->dropColumn('api_key');
            if (Schema::hasColumn('paymob_settings', 'iframe_id'))     $table->dropColumn('iframe_id');
        });
    }
    public function down(): void {}
};
