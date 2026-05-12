<?php

namespace App\Http\Controllers;

use App\Services\ApiService;

class DonateController extends Controller
{
    public function index(ApiService $api)
    {
        $projects = $api->getProjects(1, 20);

        return view('pages.donate', compact('projects'));
    }
}
