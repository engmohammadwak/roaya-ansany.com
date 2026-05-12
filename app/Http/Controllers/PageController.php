<?php

namespace App\Http\Controllers;

use App\Models\TermsOfUse;

class PageController extends Controller
{
    public function privacy()
    {
        return view('pages.privacy-policy');
    }

    public function terms()
    {
        $terms = TermsOfUse::with('sections')->first();
        return view('pages.terms', compact('terms'));
    }
}
