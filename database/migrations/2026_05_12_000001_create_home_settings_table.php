<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            // Hero
            $table->string('hero_title_ar')->nullable();
            $table->string('hero_title_en')->nullable();
            $table->text('hero_description_ar')->nullable();
            $table->text('hero_description_en')->nullable();
            $table->string('hero_label_ar')->nullable();
            $table->string('hero_label_en')->nullable();
            $table->string('hero_image')->nullable();
            // Campaign Banner
            $table->string('cb_title_ar')->nullable();
            $table->string('cb_title_en')->nullable();
            $table->string('cb_subtitle_ar')->nullable();
            $table->string('cb_subtitle_en')->nullable();
            $table->text('cb_description_ar')->nullable();
            $table->text('cb_description_en')->nullable();
            $table->string('cb_image')->nullable();
            // Why Donate Cards (JSON)
            $table->json('why_cards')->nullable();
            // Stats
            $table->string('stats_title_ar')->nullable();
            $table->string('stats_title_en')->nullable();
            $table->string('stats_image')->nullable();
            // About
            $table->string('about_title_ar')->nullable();
            $table->string('about_title_en')->nullable();
            $table->text('about_description_ar')->nullable();
            $table->text('about_description_en')->nullable();
            $table->string('about_image')->nullable();
            // Support
            $table->string('support_image')->nullable();
            $table->json('support_items')->nullable();
            // FAQ
            $table->json('faqs')->nullable();
            // Newsletter
            $table->string('newsletter_title_ar')->nullable();
            $table->string('newsletter_title_en')->nullable();
            $table->text('newsletter_description_ar')->nullable();
            $table->text('newsletter_description_en')->nullable();
            // Donation Counter
            $table->decimal('donation_goal', 15, 2)->default(0);
            $table->decimal('donation_raised', 15, 2)->default(0);
            $table->string('donation_currency', 10)->default('$');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
