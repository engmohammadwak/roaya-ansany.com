@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'المدونة':'Blog') . ' | مؤسسة رؤيا الإنسانية')
@section('description', $locale==='ar'?'اقرأ آخر مقالات ومدونات مؤسسة رؤيا الإنسانية.':'Read the latest articles and blogs from Roaya Insanya.')

@section('content')

<section class="page-hero-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url($locale) }}">{{ $locale==='ar'?'الرئيسية':'Home' }}</a></li>
                <li class="breadcrumb-item active">{{ $locale==='ar'?'المدونة':'Blog' }}</li>
            </ol>
        </nav>
        <h1 class="section-title">{{ $locale==='ar'?'المدونة':'Blog' }}</h1>
        <p class="muted-color mt-2">{{ $locale==='ar'?'رؤى ملهمة وقصص إنسانية من الميدان.':'Inspiring insights and human stories from the field.' }}</p>
    </div>
</section>

<section class="main-section">
    <div class="container">
        @if(!empty($blogs) && !empty($blogs['data']))
        <div class="row g-4">
            @foreach($blogs['data'] as $blog)
            @php
                $bImg   = $blog['image'] ?? $blog['thumbnail'] ?? 'https://roaya-ansany.com/website/images/stats-card.png';
                $bTitle = $blog['title'] ?? $blog['name'] ?? '';
                $bExc   = $blog['excerpt'] ?? $blog['description'] ?? '';
                $bDate  = isset($blog['created_at']) ? \Carbon\Carbon::parse($blog['created_at'])->translatedFormat('d M Y') : '';
                $bSlug  = $blog['slug'] ?? $blog['id'] ?? '';
                $bCat   = $blog['category'] ?? '';
            @endphp
            <div class="col-lg-4 col-md-6">
                <div class="blog-card h-100">
                    <div class="blog-img-wrap">
                        <img src="{{ $bImg }}" alt="{{ $bTitle }}" class="blog-img">
                        @if($bCat)<span class="blog-badge">{{ $bCat }}</span>@endif
                    </div>
                    <div class="blog-body">
                        @if($bDate)<div class="blog-date"><i class="fa-regular fa-calendar me-1"></i>{{ $bDate }}</div>@endif
                        <h5 class="blog-title">{{ $bTitle }}</h5>
                        @if($bExc)<p class="blog-excerpt">{{ Str::limit(strip_tags($bExc), 110) }}</p>@endif
                        <a href="{{ url($locale.'/blogs/'.$bSlug) }}" class="blog-read-more">
                            {{ $locale==='ar'?'اقرأ المزيد':'Read More' }}
                            <i class="fa-solid {{ $locale==='ar'?'fa-arrow-left':'fa-arrow-right' }} ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if(!empty($blogs['meta']) && $blogs['meta']['last_page'] > 1)
        <div class="d-flex justify-content-center mt-5">
            <nav>
                <ul class="pagination">
                    @for($p = 1; $p <= $blogs['meta']['last_page']; $p++)
                    <li class="page-item {{ $blogs['meta']['current_page'] == $p ? 'active' : '' }}">
                        <a class="page-link" href="{{ url($locale.'/blogs?page='.$p) }}">{{ $p }}</a>
                    </li>
                    @endfor
                </ul>
            </nav>
        </div>
        @endif

        @else
        <div class="text-center py-5">
            <i class="fa-regular fa-newspaper fa-4x main-color mb-4"></i>
            <h4>{{ $locale==='ar'?'لا توجد مقالات حاليًا':'No articles available yet' }}</h4>
            <p class="muted-color">{{ $locale==='ar'?'تابعنا قريبًا لأحدث المقالات والأخبار.':'Stay tuned for the latest articles and news.' }}</p>
        </div>
        @endif
    </div>
</section>

@push('styles')
<style>
.page-hero-section { background:linear-gradient(135deg,#f8fdf4,#eef7e6); padding:60px 0 40px; }
.page-hero-section .breadcrumb-item a { color:#5a9e2f; text-decoration:none; }
.blog-card { background:white; border-radius:16px; overflow:hidden; border:1px solid #e8f4d9; transition:all 0.3s; }
.blog-card:hover { box-shadow:0 8px 32px rgba(90,158,47,0.15); transform:translateY(-4px); }
.blog-img-wrap { position:relative; overflow:hidden; height:200px; }
.blog-img { width:100%; height:100%; object-fit:cover; transition:transform 0.4s; }
.blog-card:hover .blog-img { transform:scale(1.05); }
.blog-badge { position:absolute; top:12px; inset-inline-start:12px; background:#5a9e2f; color:white; font-size:11px; padding:4px 10px; border-radius:20px; }
.blog-body { padding:20px; }
.blog-date { font-size:12px; color:#999; margin-bottom:8px; }
.blog-title { font-size:16px; font-weight:700; color:#333; line-height:1.5; margin-bottom:10px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.blog-excerpt { font-size:14px; color:#777; line-height:1.7; margin-bottom:15px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
.blog-read-more { color:#5a9e2f; font-size:14px; font-weight:600; text-decoration:none; }
.blog-read-more:hover { text-decoration:underline; }
.pagination .page-link { color:#5a9e2f; border-color:#e8f4d9; }
.pagination .page-item.active .page-link { background:#5a9e2f; border-color:#5a9e2f; color:white; }
</style>
@endpush
@endsection
