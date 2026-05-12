<?php

namespace App\Http\Controllers;

use App\Services\ApiService;

class AboutController extends Controller
{
    public function index(ApiService $api)
    {
        $data = $api->getAboutData();

        return view('pages.about', compact('data'));
    }
}
