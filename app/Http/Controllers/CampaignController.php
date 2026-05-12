<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request, ApiService $api)
    {
        $page      = (int) $request->get('page', 1);
        $campaigns = $api->getProjects($page, 12);

        return view('pages.campaigns', compact('campaigns'));
    }

    public function show(string $locale, string $id, ApiService $api)
    {
        $campaign = $api->getProject($id);
        $related  = $api->getProjects(1, 3);

        return view('pages.campaign-single', compact('campaign', 'related'));
    }
}
