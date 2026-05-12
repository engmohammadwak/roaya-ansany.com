<?php

namespace App\Http\Controllers;

use App\Services\ApiService;

class PageController extends Controller
{
    public function privacy()
    {
        return view('pages.privacy-policy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function faqs(ApiService $api)
    {
        $faqs = $api->getFaqs();
        return view('pages.faqs', compact('faqs'));
    }
}
