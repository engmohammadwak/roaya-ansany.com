<?php
namespace App\Http\Controllers;
use App\Models\PrivacyPolicy;

class PrivacyController extends Controller
{
    public function index() {
        $privacy = PrivacyPolicy::first();
        return view('pages.privacy', compact('privacy'));
    }
}
