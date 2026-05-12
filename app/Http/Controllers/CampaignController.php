<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::active()->latest()->paginate(9);
        return view('pages.campaigns', compact('campaigns'));
    }

    public function show($locale, $id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('pages.campaign-single', compact('campaign'));
    }
}
