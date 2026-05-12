<?php

namespace App\Http\Controllers;

use App\Services\ApiService;

class HomeController extends Controller
{
    public function index(ApiService $api)
    {
        $data     = $api->getHomeData();
        $projects = $api->getProjects(1, 6);
        $programs = $api->getPrograms();

        return view('pages.home', compact('data', 'projects', 'programs'));
    }
}
