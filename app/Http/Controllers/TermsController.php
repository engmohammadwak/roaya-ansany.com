<?php
namespace App\Http\Controllers;
use App\Models\TermsOfUse;

class TermsController extends Controller
{
    public function index() {
        $terms = TermsOfUse::first();
        return view('pages.terms', compact('terms'));
    }
}
