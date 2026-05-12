<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()->latest()->paginate(9);
        return view('pages.blogs', compact('blogs'));
    }

    public function show($locale, $slug)
    {
        $blog = Blog::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $related = Blog::published()->where('id', '!=', $blog->id)->latest()->take(3)->get();
        return view('pages.blog-single', compact('blog', 'related'));
    }
}
