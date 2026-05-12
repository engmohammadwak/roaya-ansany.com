<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('donations', function (Blueprint $table) {
            if (!Schema::hasColumn('donations', 'campaign_id'))    $table->unsignedBigInteger('campaign_id')->nullable()->after('id');
            if (!Schema::hasColumn('donations', 'donor_name'))     $table->string('donor_name')->nullable()->after('campaign_id');
            if (!Schema::hasColumn('donations', 'donor_email'))    $table->string('donor_email')->nullable()->after('donor_name');
            if (!Schema::hasColumn('donations', 'amount'))         $table->decimal('amount', 12, 2)->default(0)->after('donor_email');
            if (!Schema::hasColumn('donations', 'currency'))       $table->string('currency', 10)->default('USD')->after('amount');
            if (!Schema::hasColumn('donations', 'amount_try'))     $table->decimal('amount_try', 12, 2)->nullable()->after('currency');
            if (!Schema::hasColumn('donations', 'card_brand'))     $table->string('card_brand', 20)->nullable()->after('amount_try');
            if (!Schema::hasColumn('donations', 'description'))    $table->string('description')->nullable()->after('card_brand');
            if (!Schema::hasColumn('donations', 'status'))         $table->enum('status', ['pending','success','failed'])->default('pending')->after('description');
            if (!Schema::hasColumn('donations', 'gateway_ref'))    $table->string('gateway_ref')->nullable()->after('status');
            if (!Schema::hasColumn('donations', 'gateway_data'))   $table->json('gateway_data')->nullable()->after('gateway_ref');
        });
    }
    public function down(): void {}
};
