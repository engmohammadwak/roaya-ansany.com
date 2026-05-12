<?php

namespace App\Http\Controllers;

use App\Models\HomeSetting;
use App\Models\Partner;
use App\Models\Setting;
use App\Services\ApiService;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $locale = app()->getLocale();

        // جلب البيانات من API مع cache 10 دقائق
        $projects = Cache::remember('home_projects_'.$locale, 600, fn() => $this->api->getProjects());
        $programs = Cache::remember('home_programs_'.$locale, 600, fn() => $this->api->getPrograms() ?? []);

        // إعدادات الصفحة الرئيسية من DB
        $hs = HomeSetting::instance();

        // الشركاء من DB
        $dbPartners = Partner::active()->get()->map(function ($p) use ($locale) {
            return [
                'name'  => $locale === 'ar' ? $p->name_ar : ($p->name_en ?: $p->name_ar),
                'image' => $p->image ? asset('storage/'.$p->image) : null,
                'icon'  => $p->icon,
                'color' => $p->color,
            ];
        })->toArray();

        // موضع النص من جدول Settings (ManageSettings)
        $heroLabelTop   = Setting::get('hero_label_top',   '');
        $heroLabelLeft  = Setting::get('hero_label_left',  '');
        $heroLabelRight = Setting::get('hero_label_right', '');

        // بناء مصفوفة $data من DB (أولوية على API)
        $data = [
            'hero' => [
                'title'       => $locale === 'ar' ? $hs->hero_title_ar       : $hs->hero_title_en,
                'description' => $locale === 'ar' ? $hs->hero_description_ar : $hs->hero_description_en,
                'label'       => $locale === 'ar' ? $hs->hero_label_ar       : $hs->hero_label_en,
                'image'       => $hs->hero_image ? asset('storage/'.$hs->hero_image) : null,
                'label_top'   => $heroLabelTop,
                'label_left'  => $heroLabelLeft,
                'label_right' => $heroLabelRight,
            ],
            'campaign_banner' => [
                'title'       => $locale === 'ar' ? $hs->cb_title_ar       : $hs->cb_title_en,
                'subtitle'    => $locale === 'ar' ? $hs->cb_subtitle_ar    : $hs->cb_subtitle_en,
                'description' => $locale === 'ar' ? $hs->cb_description_ar : $hs->cb_description_en,
                'image'       => $hs->cb_image ? asset('storage/'.$hs->cb_image) : null,
            ],
            'why_donate'  => $hs->why_cards ?? [],
            'stats_title' => $locale === 'ar' ? $hs->stats_title_ar : $hs->stats_title_en,
            'stats_image' => $hs->stats_image ? asset('storage/'.$hs->stats_image) : null,
            'about' => [
                'title'       => $locale === 'ar' ? $hs->about_title_ar       : $hs->about_title_en,
                'description' => $locale === 'ar' ? $hs->about_description_ar : $hs->about_description_en,
                'image'       => $hs->about_image ? asset('storage/'.$hs->about_image) : null,
            ],
            'support' => [
                'image' => $hs->support_image ? asset('storage/'.$hs->support_image) : null,
                'items' => $hs->support_items ?? [],
            ],
            'faqs'     => $hs->faqs ?? [],
            'partners' => $dbPartners,
            'donation_counter' => [
                'goal'     => $hs->donation_goal,
                'raised'   => $hs->donation_raised,
                'currency' => $hs->donation_currency ?? '$',
            ],
        ];

        return view('pages.home', compact('data', 'projects', 'programs'));
    }
}
