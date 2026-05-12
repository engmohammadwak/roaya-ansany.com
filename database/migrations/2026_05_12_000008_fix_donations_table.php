<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            // Make name nullable so it doesn't break
            $table->string('name')->nullable()->change();

            // Add extra columns if they don't exist
            if (!Schema::hasColumn('donations', 'card_brand'))
                $table->string('card_brand', 30)->nullable()->after('currency');

            if (!Schema::hasColumn('donations', 'description'))
                $table->string('description')->nullable()->after('card_brand');

            if (!Schema::hasColumn('donations', 'gateway_ref'))
                $table->string('gateway_ref')->nullable()->after('transaction_id');

            if (!Schema::hasColumn('donations', 'gateway_data'))
                $table->json('gateway_data')->nullable()->after('gateway_ref');
        });

        // Fix status enum to include 'success'
        DB::statement("ALTER TABLE donations MODIFY COLUMN status ENUM('pending','completed','success','failed') DEFAULT 'pending'");
    }
    public function down(): void {}
};
