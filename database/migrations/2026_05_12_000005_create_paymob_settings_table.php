<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('paymob_settings', function (Blueprint $table) {
            $table->id();
            $table->string('api_key')->nullable();
            $table->string('integration_id')->nullable();
            $table->string('iframe_id')->nullable();
            $table->string('hmac_secret')->nullable();
            $table->string('base_url')->default('https://accept.paymob.com');
            $table->boolean('is_active')->default(false);
            $table->boolean('test_mode')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('paymob_settings');
    }
};
