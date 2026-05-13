<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Setting;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderByDesc('created_at')->paginate(9);

        $locale = app()->getLocale();
        $isAr   = $locale === 'ar';

        $heroTitle = Setting::get(
            $isAr ? 'projects_hero_title_ar' : 'projects_hero_title_en',
            $isAr ? '\u0645\u0634\u0627\u0631\u064a\u0639\u0646\u0627' : 'Our Projects'
        );
        $heroDesc = Setting::get(
            $isAr ? 'projects_hero_desc_ar' : 'projects_hero_desc_en',
            $isAr ? '\u0633\u0627\u0647\u0645 \u0641\u064a \u062f\u0639\u0645 \u0645\u0634\u0627\u0631\u064a\u0639\u0646\u0627 \u0627\u0644\u0625\u0646\u0633\u0627\u0646\u064a\u0629' : 'Support our humanitarian projects'
        );

        return view('pages.projects', compact('projects', 'heroTitle', 'heroDesc'));
    }
}
