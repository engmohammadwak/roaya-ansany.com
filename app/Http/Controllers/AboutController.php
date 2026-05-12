<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use App\Models\AboutWorkField;

class AboutController extends Controller
{
    public function index()
    {
        $about = AboutPage::first();
        $workFields = AboutWorkField::orderBy('sort_order')->get();
        return view('pages.about', compact('about', 'workFields'));
    }
}
