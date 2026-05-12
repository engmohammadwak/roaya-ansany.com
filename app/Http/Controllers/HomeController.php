<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Campaign;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()->latest()->take(3)->get();
        $campaigns = Campaign::active()->latest()->take(3)->get();
        $settings = Setting::getAllSettings();

        return view('pages.home', compact('blogs', 'campaigns', 'settings'));
    }
}
