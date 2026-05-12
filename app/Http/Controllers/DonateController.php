<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class DonateController extends Controller
{
    public function index(Request $request, ApiService $api)
    {
        $projects = $api->getProjects(1, 50);
        $amount   = $request->get('amount', '');

        return view('pages.donate', compact('projects', 'amount'));
    }
}
