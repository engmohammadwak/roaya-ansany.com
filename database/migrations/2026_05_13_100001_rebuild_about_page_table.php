<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('about_page');

        Schema::create('about_page', function (Blueprint $table) {
            $table->id();

            // ===== HERO =====
            $table->string('hero_title_ar')->nullable();
            $table->string('hero_title_en')->nullable();
            $table->text('hero_description_ar')->nullable();
            $table->text('hero_description_en')->nullable();
            $table->string('hero_image_1')->nullable();

            // ===== VISION SECTION =====
            $table->text('vision_section_desc_ar')->nullable();
            $table->text('vision_section_desc_en')->nullable();

            // ===== VISION CARD =====
            $table->text('vision_text_ar')->nullable();
            $table->text('vision_text_en')->nullable();

            // ===== GOALS CARD (JSON list) =====
            $table->json('goal_points_ar')->nullable();
            $table->json('goal_points_en')->nullable();

            // ===== MISSION CARD =====
            $table->text('mission_text_ar')->nullable();
            $table->text('mission_text_en')->nullable();

            // ===== STORY / WHERE WE WORK =====
            $table->text('story_paragraph_1_ar')->nullable();
            $table->text('story_paragraph_1_en')->nullable();
            $table->text('story_paragraph_2_ar')->nullable();
            $table->text('story_paragraph_2_en')->nullable();
            $table->text('story_cta_text_ar')->nullable();
            $table->text('story_cta_text_en')->nullable();
            $table->string('story_image')->nullable();

            // ===== CTA SECTION =====
            $table->text('cta_description_ar')->nullable();
            $table->text('cta_description_en')->nullable();

            $table->timestamps();
        });

        // seed one default row so Edit page works immediately
        DB::table('about_page')->insert([
            'hero_title_ar'          => 'مؤسسة رؤيا الإنسانية',
            'hero_title_en'          => 'Roaya Humanitarian Foundation',
            'hero_description_ar'    => 'رؤيا مؤسسة خيرية غير ربحية تعمل في المجال الإنساني.',
            'hero_description_en'    => 'Roaya is a non-profit humanitarian charity that provides life-saving assistance.',
            'vision_section_desc_ar' => 'نسعى إلى بناء مجتمع أكثر تكافلاً وعدلاً.',
            'vision_section_desc_en' => 'We strive to build a more equitable and just society.',
            'vision_text_ar'         => 'استجابة إنسانية شاملة تحمي كرامة الإنسان.',
            'vision_text_en'         => 'A comprehensive humanitarian response that protects human dignity.',
            'goal_points_ar'         => json_encode(['تنفيذ مشاريع إنسانية وتنموية مستدامة.','تقديم المساعدات العاجلة للنازحين.','دعم الأيتام والأرامل.','تعزيز قيم العمل التطوعي.']),
            'goal_points_en'         => json_encode(['Implement humanitarian projects.','Provide emergency aid to displaced people.','Support orphans and widows.','Promote volunteerism.']),
            'mission_text_ar'        => 'تقديم تدخلات إنسانية تستند إلى الاحتياج الحقيقي.',
            'mission_text_en'        => 'Providing humanitarian interventions based on real need.',
            'story_paragraph_1_ar'   => 'مؤسسة رؤيا الإنسانية هي مؤسسة أهلية غير ربحية.',
            'story_paragraph_1_en'   => 'Roaya is a non-profit civil organization.',
            'story_paragraph_2_ar'   => 'يعتمد تنفيذ البرامج على تقييمات احتياج دورية.',
            'story_paragraph_2_en'   => 'Programs rely on periodic needs assessments.',
            'story_cta_text_ar'      => 'ساعدنا في تقديم المساعدة العاجلة.',
            'story_cta_text_en'      => 'Help us provide urgent assistance.',
            'cta_description_ar'     => 'تبرّع الآن وأنقذ حياة.',
            'cta_description_en'     => 'Donate now and save a life.',
            'created_at'             => now(),
            'updated_at'             => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('about_page');
    }
};
