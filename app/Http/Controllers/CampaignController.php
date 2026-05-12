<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request, ApiService $api)
    {
        $page = $request->get('page', 1);
        $campaigns = $api->getProjects($page);

        return view('pages.campaigns', compact('campaigns'));
    }

    public function show(string $locale, string $id, ApiService $api)
    {
        $campaign = $api->getProject($id);

        return view('pages.campaign-single', compact('campaign'));
    }
}
