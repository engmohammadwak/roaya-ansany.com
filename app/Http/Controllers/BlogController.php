<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request, ApiService $api)
    {
        $page  = (int) $request->get('page', 1);
        $blogs = $api->getBlogs($page);

        return view('pages.blogs', compact('blogs'));
    }

    public function show(string $locale, string $slug, ApiService $api)
    {
        $blog   = $api->getBlog($slug);
        $recent = $api->getBlogs(1);

        return view('pages.blog-single', compact('blog', 'recent'));
    }
}
