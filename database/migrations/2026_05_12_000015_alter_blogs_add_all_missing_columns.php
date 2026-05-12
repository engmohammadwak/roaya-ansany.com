<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Use raw SQL so IF NOT EXISTS works safely
        $columns = [
            "published_at"  => "DATETIME NULL",
            "body_ar"       => "LONGTEXT NULL",
            "body_en"       => "LONGTEXT NULL",
            "meta_title_ar" => "VARCHAR(255) NULL",
            "meta_title_en" => "VARCHAR(255) NULL",
            "meta_desc_ar"  => "TEXT NULL",
            "meta_desc_en"  => "TEXT NULL",
            "og_image"      => "VARCHAR(255) NULL",
            "focus_keyword" => "VARCHAR(255) NULL",
            "canonical_url" => "VARCHAR(255) NULL",
            "robots"        => "VARCHAR(100) NOT NULL DEFAULT 'index, follow'",
            "schema_type"   => "VARCHAR(100) NOT NULL DEFAULT 'BlogPosting'",
        ];

        foreach ($columns as $column => $definition) {
            if (!Schema::hasColumn('blogs', $column)) {
                DB::statement("ALTER TABLE blogs ADD COLUMN `{$column}` {$definition}");
            }
        }
    }

    public function down(): void {}
};
