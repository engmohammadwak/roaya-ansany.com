<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Setting;

class DonateController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::active()->get();
        $settings = Setting::getAllSettings();
        return view('pages.donate', compact('campaigns', 'settings'));
    }
}
