<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class PageController extends Controller
{
    public function privacy()
    {
        $settings = Setting::getAllSettings();
        return view('pages.privacy', compact('settings'));
    }

    public function terms()
    {
        $settings = Setting::getAllSettings();
        return view('pages.terms', compact('settings'));
    }
}
