@extends('layouts.app')
@php $locale = app()->getLocale(); $isAr = $locale === 'ar'; @endphp
@section('title', ($isAr ? 'المدونة' : 'Blog') . ' | مؤسسة رؤيا الإنسانية')
@push('styles')
<style>
.blog-hero { background:linear-gradient(135deg,#1a7a4a,#2ecc71); padding:100px 0 60px; color:#fff; text-align:center; }
.blog-hero h1 { font-size:2.5rem; font-weight:700; }
.blog-section { padding:70px 0; background:#f8fffe; }
.blog-card { background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,.07); transition:transform .3s,box-shadow .3s; height:100%; display:flex; flex-direction:column; }
.blog-card:hover { transform:translateY(-6px); box-shadow:0 10px 35px rgba(26,122,74,.15); }
.blog-card img { width:100%; height:200px; object-fit:cover; }
.blog-card-body { padding:22px; flex:1; display:flex; flex-direction:column; }
.blog-category { display:inline-block; background:#e8f5ee; color:#1a7a4a; padding:3px 12px; border-radius:20px; font-size:.8rem; font-weight:600; margin-bottom:10px; }
.blog-card-body h4 { font-weight:700; color:#222; margin-bottom:10px; font-size:1.05rem; line-height:1.5; }
.blog-card-body p { color:#666; font-size:.9rem; line-height:1.7; flex:1; }
.blog-meta { font-size:.82rem; color:#aaa; margin-top:15px; }
.blog-card-body a.read-more { color:#1a7a4a; font-weight:600; text-decoration:none; font-size:.9rem; }
.breadcrumb-section { background:#f0faf5; padding:12px 0; border-bottom:1px solid #d4edda; }
.breadcrumb-section a { color:#1a7a4a; text-decoration:none; }
</style>
@endpush
@section('content')
<div class="breadcrumb-section">
    <div class="container"><small><a href="{{ url($locale.'/') }}">{{ $isAr?'الرئيسية':'Home' }}</a><span style="margin:0 8px;color:#888">›</span><span class="text-muted">{{ $isAr?'المدونة':'Blog' }}</span></small></div>
</div>
<section class="blog-hero">
    <div class="container">
        <h1>{{ $isAr ? 'المدونة' : 'Blog' }}</h1>
        <p style="opacity:.9;margin-top:10px">{{ $isAr?'آخر المقالات والأخبار':'Latest Articles & News' }}</p>
    </div>
</section>
<section class="blog-section">
    <div class="container">
        <div class="row g-4">
            @forelse($posts as $post)
            <div class="col-md-6 col-lg-4">
                <div class="blog-card">
                    @if($post->image)
                    <a href="{{ url($locale.'/blog/'.$post->slug) }}">
                        <img src="{{ Storage::url($post->image) }}" alt="{{ $isAr?$post->title_ar:$post->title_en }}">
                    </a>
                    @endif
                    <div class="blog-card-body">
                        @if($post->category_ar)
                        <span class="blog-category">{{ $isAr?$post->category_ar:$post->category_en }}</span>
                        @endif
                        <h4><a href="{{ url($locale.'/blog/'.$post->slug) }}" class="text-dark text-decoration-none">{{ $isAr?$post->title_ar:$post->title_en }}</a></h4>
                        @if($post->excerpt_ar)
                        <p>{{ $isAr?$post->excerpt_ar:$post->excerpt_en }}</p>
                        @endif
                        <div class="blog-meta">
                            @if($post->author) <span>✍ {{ $post->author }}</span> &nbsp; @endif
                            @if($post->published_at) <span>📅 {{ $post->published_at->format('Y-m-d') }}</span> @endif
                        </div>
                        <a href="{{ url($locale.'/blog/'.$post->slug) }}" class="read-more d-block mt-3">{{ $isAr?'اقرأ المزيد ←':'Read more →' }}</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">{{ $isAr?'لا توجد مقالات حالياً':'No posts available' }}</div>
            @endforelse
        </div>
        @if($posts->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $posts->links() }}</div>
        @endif
    </div>
</section>
@endsection
