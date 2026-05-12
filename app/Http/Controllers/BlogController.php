<?php
namespace App\Http\Controllers;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index() {
        $posts = BlogPost::where('is_published', true)->orderByDesc('published_at')->paginate(9);
        return view('pages.blog', compact('posts'));
    }

    public function show($locale, $slug) {
        $post = BlogPost::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('pages.blog-single', compact('post'));
    }
}
