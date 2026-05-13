<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('contact_page')) {
            Schema::create('contact_page', function (Blueprint $table) {
                $table->id();
                $table->string('hero_title_ar')->nullable();
                $table->string('hero_title_en')->nullable();
                $table->text('hero_subtitle_ar')->nullable();
                $table->text('hero_subtitle_en')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('fax')->nullable();
                $table->string('work_hours_ar')->nullable();
                $table->string('work_hours_en')->nullable();
                $table->string('whatsapp')->nullable();
                $table->string('facebook')->nullable();
                $table->string('instagram')->nullable();
                $table->string('twitter')->nullable();
                $table->string('youtube')->nullable();
                $table->text('card_text_ar')->nullable();
                $table->text('card_text_en')->nullable();
                $table->string('success_msg_ar')->nullable();
                $table->string('success_msg_en')->nullable();
                $table->string('fail_msg_ar')->nullable();
                $table->string('fail_msg_en')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('contact_page', function (Blueprint $table) {
                if (!Schema::hasColumn('contact_page', 'hero_title_ar'))     $table->string('hero_title_ar')->nullable();
                if (!Schema::hasColumn('contact_page', 'hero_title_en'))     $table->string('hero_title_en')->nullable();
                if (!Schema::hasColumn('contact_page', 'hero_subtitle_ar'))  $table->text('hero_subtitle_ar')->nullable();
                if (!Schema::hasColumn('contact_page', 'hero_subtitle_en'))  $table->text('hero_subtitle_en')->nullable();
                if (!Schema::hasColumn('contact_page', 'email'))             $table->string('email')->nullable();
                if (!Schema::hasColumn('contact_page', 'phone'))             $table->string('phone')->nullable();
                if (!Schema::hasColumn('contact_page', 'fax'))               $table->string('fax')->nullable();
                if (!Schema::hasColumn('contact_page', 'work_hours_ar'))     $table->string('work_hours_ar')->nullable();
                if (!Schema::hasColumn('contact_page', 'work_hours_en'))     $table->string('work_hours_en')->nullable();
                if (!Schema::hasColumn('contact_page', 'whatsapp'))          $table->string('whatsapp')->nullable();
                if (!Schema::hasColumn('contact_page', 'facebook'))          $table->string('facebook')->nullable();
                if (!Schema::hasColumn('contact_page', 'instagram'))         $table->string('instagram')->nullable();
                if (!Schema::hasColumn('contact_page', 'twitter'))           $table->string('twitter')->nullable();
                if (!Schema::hasColumn('contact_page', 'youtube'))           $table->string('youtube')->nullable();
                if (!Schema::hasColumn('contact_page', 'card_text_ar'))      $table->text('card_text_ar')->nullable();
                if (!Schema::hasColumn('contact_page', 'card_text_en'))      $table->text('card_text_en')->nullable();
                if (!Schema::hasColumn('contact_page', 'success_msg_ar'))    $table->string('success_msg_ar')->nullable();
                if (!Schema::hasColumn('contact_page', 'success_msg_en'))    $table->string('success_msg_en')->nullable();
                if (!Schema::hasColumn('contact_page', 'fail_msg_ar'))       $table->string('fail_msg_ar')->nullable();
                if (!Schema::hasColumn('contact_page', 'fail_msg_en'))       $table->string('fail_msg_en')->nullable();
            });
        }
    }
    public function down(): void {
        Schema::dropIfExists('contact_page');
    }
};
