<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('contact_page')) {
            Schema::create('contact_page', function (Blueprint $table) {
                $table->id();
                $table->string('hero_title_ar')->nullable();
                $table->string('hero_title_en')->nullable();
                $table->text('hero_subtitle_ar')->nullable();
                $table->text('hero_subtitle_en')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('whatsapp')->nullable();
                $table->text('address_ar')->nullable();
                $table->text('address_en')->nullable();
                $table->string('facebook')->nullable();
                $table->string('twitter')->nullable();
                $table->string('instagram')->nullable();
                $table->string('youtube')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('contact_messages')) {
            Schema::create('contact_messages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('subject')->nullable();
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('faq_categories')) {
            Schema::create('faq_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name_ar');
                $table->string('name_en');
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('faqs')) {
            Schema::create('faqs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('faq_category_id')->nullable()->constrained()->nullOnDelete();
                $table->text('question_ar');
                $table->text('question_en');
                $table->longText('answer_ar');
                $table->longText('answer_en');
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('blog_posts')) {
            Schema::create('blog_posts', function (Blueprint $table) {
                $table->id();
                $table->string('title_ar');
                $table->string('title_en');
                $table->string('slug')->unique();
                $table->text('excerpt_ar')->nullable();
                $table->text('excerpt_en')->nullable();
                $table->longText('body_ar')->nullable();
                $table->longText('body_en')->nullable();
                $table->string('image')->nullable();
                $table->string('category_ar')->nullable();
                $table->string('category_en')->nullable();
                $table->string('author')->nullable();
                $table->boolean('is_published')->default(true);
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('programs')) {
            Schema::create('programs', function (Blueprint $table) {
                $table->id();
                $table->string('title_ar');
                $table->string('title_en');
                $table->text('description_ar')->nullable();
                $table->text('description_en')->nullable();
                $table->longText('body_ar')->nullable();
                $table->longText('body_en')->nullable();
                $table->string('image')->nullable();
                $table->string('category_ar')->nullable();
                $table->string('category_en')->nullable();
                $table->string('icon')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('privacy_policy')) {
            Schema::create('privacy_policy', function (Blueprint $table) {
                $table->id();
                $table->string('title_ar')->nullable();
                $table->string('title_en')->nullable();
                $table->longText('content_ar');
                $table->longText('content_en');
                $table->timestamp('last_updated')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('terms_of_use')) {
            Schema::create('terms_of_use', function (Blueprint $table) {
                $table->id();
                $table->string('title_ar')->nullable();
                $table->string('title_en')->nullable();
                $table->longText('content_ar');
                $table->longText('content_en');
                $table->timestamp('last_updated')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->id();
                $table->string('title_ar');
                $table->string('title_en');
                $table->text('description_ar')->nullable();
                $table->text('description_en')->nullable();
                $table->longText('body_ar')->nullable();
                $table->longText('body_en')->nullable();
                $table->string('image')->nullable();
                $table->string('country_ar')->nullable();
                $table->string('country_en')->nullable();
                $table->string('category_ar')->nullable();
                $table->string('category_en')->nullable();
                $table->decimal('goal_amount', 15, 2)->default(0);
                $table->decimal('raised_amount', 15, 2)->default(0);
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('terms_of_use');
        Schema::dropIfExists('privacy_policy');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('faq_categories');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('contact_page');
    }
};
