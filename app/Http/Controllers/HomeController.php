<?php

namespace App\Http\Controllers;

use App\Models\Faq;
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

        $projects = Cache::remember('home_projects_'.$locale, 600, fn() => $this->api->getProjects());
        $programs = Cache::remember('home_programs_'.$locale, 600, fn() => $this->api->getPrograms() ?? []);

        $hs = HomeSetting::instance();

        // ── Partners
        $dbPartners = Partner::active()->get()->map(function ($p) use ($locale) {
            return [
                'name'  => $locale === 'ar' ? $p->name_ar : ($p->name_en ?: $p->name_ar),
                'image' => $p->image ? asset('storage/'.$p->image) : null,
                'icon'  => $p->icon,
                'color' => $p->color,
            ];
        })->toArray();

        // ── FAQs
        $dbFaqs = Faq::orderBy('sort_order')->get()->map(function ($f) use ($locale) {
            return [
                'question'  => $locale === 'ar' ? $f->question_ar : ($f->question_en ?: $f->question_ar),
                'answer'    => $locale === 'ar' ? $f->answer_ar   : ($f->answer_en   ?: $f->answer_ar),
                'is_active' => $f->is_active,
            ];
        })->filter(fn($f) => $f['is_active'])->values()->toArray();

        $faqs = !empty($dbFaqs) ? $dbFaqs : ($hs->faqs ?? []);

        // ── Why Cards — respect locale
        $rawWhyCards = $hs->why_cards ?? [];
        $whyCards = array_map(function ($card) use ($locale) {
            $isAr = $locale === 'ar';
            return [
                'icon'        => $card['icon']        ?? null,
                'icon_color'  => $card['icon_color']  ?? null,
                'color'       => $card['color']       ?? null,
                'title'       => $isAr
                    ? ($card['title_ar']       ?? $card['title']       ?? '')
                    : ($card['title_en']       ?: ($card['title_ar']   ?? $card['title']   ?? '')),
                'description' => $isAr
                    ? ($card['description_ar'] ?? $card['description'] ?? '')
                    : ($card['description_en'] ?: ($card['description_ar'] ?? $card['description'] ?? '')),
            ];
        }, $rawWhyCards);

        // ── Support Items — respect locale
        $rawSupportItems = $hs->support_items ?? [];
        $supportItems = array_map(function ($item) use ($locale) {
            if (!is_array($item)) return $item;
            $isAr = $locale === 'ar';
            return [
                'title' => $isAr
                    ? ($item['title_ar'] ?? $item['title'] ?? '')
                    : ($item['title_en'] ?: ($item['title_ar'] ?? $item['title'] ?? '')),
            ];
        }, $rawSupportItems);

        $heroLabelTop   = Setting::get('hero_label_top',   '');
        $heroLabelLeft  = Setting::get('hero_label_left',  '');
        $heroLabelRight = Setting::get('hero_label_right', '');

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
            'why_donate'       => $whyCards,
            'why_donate_label' => $locale === 'ar' ? $hs->why_donate_label_ar : $hs->why_donate_label_en,
            'why_donate_title' => $locale === 'ar' ? $hs->why_donate_title_ar : $hs->why_donate_title_en,
            'stats_title'      => $locale === 'ar' ? $hs->stats_title_ar : $hs->stats_title_en,
            'stats_image'      => $hs->stats_image ? asset('storage/'.$hs->stats_image) : null,
            'about' => [
                'title'       => $locale === 'ar' ? $hs->about_title_ar       : $hs->about_title_en,
                'description' => $locale === 'ar' ? $hs->about_description_ar : $hs->about_description_en,
                'image'       => $hs->about_image ? asset('storage/'.$hs->about_image) : null,
            ],
            'support' => [
                'image'       => $hs->support_image ? asset('storage/'.$hs->support_image) : null,
                'title'       => $locale === 'ar' ? $hs->support_title_ar       : $hs->support_title_en,
                'description' => $locale === 'ar' ? $hs->support_description_ar : $hs->support_description_en,
                'items'       => $supportItems,
            ],
            'faqs'    => $faqs,
            'partners' => $dbPartners,
            'donation_counter' => [
                'goal'     => $hs->donation_goal,
                'raised'   => $hs->donation_raised,
                'currency' => $hs->donation_currency ?? '$',
            ],
            'cta_title'       => $locale === 'ar' ? ($hs->cta_title_ar ?? '')       : ($hs->cta_title_en ?? ''),
            'cta_description' => $locale === 'ar' ? ($hs->cta_description_ar ?? '') : ($hs->cta_description_en ?? ''),
            'cta_image'       => $hs->cta_image ?? null,
            'faq_section_label' => $locale === 'ar'
                ? Setting::get('home_faq_label_ar', 'الأسئلة الشائعة')
                : Setting::get('home_faq_label_en', 'FAQ'),
            'faq_section_title' => $locale === 'ar'
                ? Setting::get('home_faq_title_ar', 'أسئلة وأجوبة')
                : Setting::get('home_faq_title_en', 'Q&A'),
        ];

        return view('pages.home', compact('data', 'projects', 'programs'));
    }
}
