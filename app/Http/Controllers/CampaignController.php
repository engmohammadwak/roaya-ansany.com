<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Setting;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::active()
            ->orderByDesc('created_at')
            ->paginate(9);

        $locale = app()->getLocale();
        $isAr   = $locale === 'ar';

        $heroTitle = Setting::get(
            $isAr ? 'campaigns_hero_title_ar' : 'campaigns_hero_title_en',
            $isAr ? '\u0634\u0627\u0631\u0643 \u0641\u064a \u0635\u0646\u0639 \u0627\u0644\u0623\u0645\u0644' : 'Be Part of Making Hope'
        );
        $heroDesc = Setting::get(
            $isAr ? 'campaigns_hero_desc_ar' : 'campaigns_hero_desc_en',
            $isAr
                ? '\u0627\u0643\u062a\u0634\u0641 \u0627\u0644\u062d\u0645\u0644\u0627\u062a \u0627\u0644\u0625\u0646\u0633\u0627\u0646\u064a\u0629 \u0648\u0643\u0646 \u062c\u0632\u0621\u064b\u0627 \u0645\u0646 \u0627\u0644\u062a\u063a\u064a\u064a\u0631.'
                : 'Discover humanitarian campaigns and be part of the change.'
        );

        return view('pages.campaigns', compact('campaigns', 'heroTitle', 'heroDesc'));
    }

    public function show(string $locale, string $slug)
    {
        $campaign = Campaign::active()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Campaign::active()
            ->where('id', '!=', $campaign->id)
            ->latest()
            ->take(3)
            ->get();

        return view('pages.campaign-single', compact('campaign', 'related'));
    }
}
