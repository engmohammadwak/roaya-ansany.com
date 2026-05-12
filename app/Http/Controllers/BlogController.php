<?php
namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\BlogPage;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private const PER_PAGE = 8;

    public function index() {
        $locale   = app()->getLocale();
        $page     = BlogPage::first();
        $posts    = Blog::published()->latest()->take(self::PER_PAGE)->get();
        $total    = Blog::published()->count();
        $hasMore  = $total > self::PER_PAGE;
        return view('pages.blogs', compact('posts','page','total','hasMore','locale'));
    }

    public function loadMore(Request $request) {
        $locale  = app()->getLocale();
        $offset  = (int) $request->get('offset', self::PER_PAGE);
        $posts   = Blog::published()->latest()->skip($offset)->take(self::PER_PAGE)->get();
        $total   = Blog::published()->count();
        $hasMore = ($offset + self::PER_PAGE) < $total;

        $html = '';
        foreach ($posts as $post) {
            $img   = $post->image ? asset('storage/'.$post->image) : asset('website/images/stats-card.png');
            $title = $locale === 'ar' ? $post->title_ar : ($post->title_en ?: $post->title_ar);
            $date  = $post->published_at ? $post->published_at->format('d/m/Y') :
                     ($post->created_at ? $post->created_at->format('d/m/Y') : '');
            $slug  = $post->slug;
            $html .= view('partials.blog-card', compact('post','img','title','date','slug','locale'))->render();
        }

        return response()->json([
            'html'        => $html,
            'has_more'    => $hasMore,
            'total_count' => $total,
        ]);
    }

    public function show($locale, $slug) {
        $post     = Blog::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $isAr     = $locale === 'ar';
        return view('pages.blog-single', compact('post','isAr'));
    }
}
