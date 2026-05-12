<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::active()
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('pages.campaigns', compact('campaigns'));
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
