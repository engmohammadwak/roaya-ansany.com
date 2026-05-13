<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Setting;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderByDesc('created_at')->paginate(9);

        $locale = app()->getLocale();
        $isAr   = $locale === 'ar';

        $heroTitle = Setting::get(
            $isAr ? 'programs_hero_title_ar' : 'programs_hero_title_en',
            $isAr ? '\u0628\u0631\u0627\u0645\u062c\u0646\u0627' : 'Our Programs'
        );
        $heroDesc = Setting::get(
            $isAr ? 'programs_hero_desc_ar' : 'programs_hero_desc_en',
            $isAr ? '\u062a\u0639\u0631\u0651\u0641 \u0639\u0644\u0649 \u0628\u0631\u0627\u0645\u062c\u0646\u0627 \u0627\u0644\u0625\u0646\u0633\u0627\u0646\u064a\u0629 \u0627\u0644\u0645\u062a\u0646\u0648\u0639\u0629' : 'Explore our diverse humanitarian programs'
        );

        $categories_ar = $programs->getCollection()->pluck('category_ar')->filter()->unique()->values();
        $categories_en = $programs->getCollection()->pluck('category_en')->filter()->unique()->values();

        return view('pages.programs', compact('programs', 'heroTitle', 'heroDesc', 'categories_ar', 'categories_en'));
    }
}
