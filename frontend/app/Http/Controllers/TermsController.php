<?php
namespace App\Http\Controllers;
use App\Models\TermsOfUse;

class TermsController extends Controller {
    public function index() {
        $terms = TermsOfUse::with('sections')->first();
        return view('pages.terms', compact('terms'));
    }
}
