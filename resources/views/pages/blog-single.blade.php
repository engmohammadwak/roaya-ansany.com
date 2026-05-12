@extends('layouts.app')
@php
    $locale  = app()->getLocale();
    $isAr    = $locale === 'ar';
    $title   = $isAr ? $post->title_ar : ($post->title_en ?: $post->title_ar);
    $body    = $isAr ? $post->body_ar  : ($post->body_en  ?: $post->body_ar);
    $excerpt = $isAr ? ($post->excerpt_ar ?? '') : ($post->excerpt_en ?? $post->excerpt_ar ?? '');
    $img     = $post->image ? asset('storage/'.$post->image) : null;
    $ogImg   = $post->og_image ? asset('storage/'.$post->og_image) : $img ?? asset('website/images/og-default.jpg');
    $date    = $post->published_at
               ? $post->published_at->translatedFormat('d F, Y')
               : $post->created_at->translatedFormat('d F, Y');
    $metaTitle = $isAr
        ? ($post->meta_title_ar ?: $title)
        : ($post->meta_title_en ?: $title);
    $metaDesc  = $isAr
        ? ($post->meta_desc_ar ?: Str::limit(strip_tags($body ?? ''), 160))
        : ($post->meta_desc_en ?: Str::limit(strip_tags($body ?? ''), 160));
    $canonical = $post->canonical_url ?: url($locale.'/blogs/'.$post->slug);
    $robots    = $post->robots ?? 'index, follow';
    $recents   = \App\Models\Blog::published()
                 ->where('id', '!=', $post->id)
                 ->latest()
                 ->take(4)
                 ->get();
@endphp

{{-- SEO --}}
@section('title', $metaTitle . ' | ' . config('app.name'))
@section('description', $metaDesc)

@push('head')
<link rel="canonical" href="{{ $canonical }}">
<meta name="robots" content="{{ $robots }}">
@if($post->focus_keyword)
<meta name="keywords" content="{{ $post->focus_keyword }}">
@endif

{{-- Open Graph --}}
<meta property="og:type"        content="article">
<meta property="og:title"       content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDesc }}">
<meta property="og:url"         content="{{ $canonical }}">
<meta property="og:image"       content="{{ $ogImg }}">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale"      content="{{ $isAr ? 'ar_AR' : 'en_US' }}">

{{-- Twitter Card --}}
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDesc }}">
<meta name="twitter:image"       content="{{ $ogImg }}">

{{-- Schema.org --}}
@php
    $schemaType = $post->schema_type ?? 'BlogPosting';
    $schemaImg  = $ogImg;
@endphp
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "{{ $schemaType }}",
    "headline": "{{ $metaTitle }}",
    "description": "{{ $metaDesc }}",
    "image": "{{ $schemaImg }}",
    "datePublished": "{{ $post->published_at?->toIso8601String() }}",
    "dateModified": "{{ $post->updated_at?->toIso8601String() }}",
    "author": {
        "@type": "Organization",
        "name": "{{ config('app.name') }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "{{ config('app.name') }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('website/images/logo.jpeg') }}"
        }
    },
    "url": "{{ $canonical }}"
}
</script>
@endpush

@section('content')
<div class="blog first-container">

    {{-- Hero / Title --}}
    <section class="mt-5">
        <div class="container">

            <div class="breadcrumbs justify-content-center mt-4 mb-4">
                <a href="{{ url($locale) }}">
                    <img class="me-2" src="{{ asset('website/images/home.svg') }}" alt="home">
                    {{ $isAr ? 'الرئيسية' : 'Home' }}
                </a>
                <span>/</span>
                <a href="{{ url($locale.'/blogs') }}" class="active">
                    {{ $isAr ? 'مدوناتنا' : 'Our Blog' }}
                </a>
                <span>/</span>
                <a href="#" class="active">{{ Str::limit($title, 40) }}</a>
            </div>

            <div class="text-center mx-auto" style="max-width:780px;">
                <h1 class="mt-3 mb-4 section-title fw-medium">{{ $title }}</h1>
            </div>

            @if($img)
            <img class="img-fluid object-fit-cover d-block mx-auto rounded-3 mb-4"
                 src="{{ $img }}" alt="{{ $title }}"
                 data-aos="zoom-in" data-aos-delay="200"
                 style="max-height:480px; width:100%;">
            @endif

        </div>
    </section>

    {{-- Content + Sidebar --}}
    <section class="content">
        <div class="container">
            <div class="row">

                {{-- Main --}}
                <div class="col-lg-8 mb-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img width="18" height="18" src="{{ asset('website/images/time.svg') }}" alt="time">
                        <span class="dark-text-color">{{ $date }}</span>
                    </div>

                    <div class="blog-content">
                        {!! $body !!}
                    </div>

                    {{-- Share --}}
                    <div class="d-flex align-items-center gap-3 mt-5 pt-3 border-top flex-wrap">
                        <span class="fw-semibold">{{ $isAr ? 'شارك المقال' : 'Share' }}:</span>
                        @php
                            $shareUrl   = urlencode(request()->url());
                            $shareTitle = urlencode($title);
                        @endphp
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                           target="_blank" rel="noopener" title="Facebook">
                            <img width="28" src="{{ asset('website/images/facebook.svg') }}" alt="Facebook">
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
                           target="_blank" rel="noopener" title="X (Twitter)">
                            <img width="28" src="{{ asset('website/images/xtwitter.png') }}" alt="X">
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}"
                           target="_blank" rel="noopener" title="WhatsApp">
                            <svg fill="#25D366" width="28px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M26.576 5.363c-2.69-2.69-6.406-4.354-10.511-4.354-8.209 0-14.865 6.655-14.865 14.865 0 2.732 0.737 5.291 2.022 7.491l-2.109 7.702 7.879-2.067c2.051 1.139 4.498 1.809 7.102 1.809h0.006c8.209-0.003 14.862-6.659 14.862-14.868 0-4.103-1.662-7.817-4.349-10.507z"></path></svg>
                        </a>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div style="position:sticky; top:90px;">

                        <div class="why-donate-card mb-4">
                            <h5 class="mb-3">{{ $isAr ? 'ساهم في الخير' : 'Contribute' }}</h5>
                            <form action="{{ url($locale.'/donate') }}" method="GET">
                                <input type="hidden" name="source" value="blog-single">
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="text" name="amount" class="form-input w-100 mb-3"
                                       placeholder="{{ $isAr ? 'ادخل المبلغ' : 'Enter amount' }}">
                                <button type="submit" class="btn-donate w-100">
                                    {{ $isAr ? 'تبرع الآن' : 'Donate Now' }}
                                </button>
                            </form>
                        </div>

                        @if($recents->isNotEmpty())
                        <div class="why-donate-card">
                            <h5 class="mb-4">{{ $isAr ? 'مقالات حديثة' : 'Recent Articles' }}</h5>
                            @foreach($recents as $rec)
                            @php
                                $recTitle = $isAr ? $rec->title_ar : ($rec->title_en ?: $rec->title_ar);
                                $recImg   = $rec->image ? asset('storage/'.$rec->image) : null;
                                $recDate  = $rec->published_at?->format('d/m/Y') ?? $rec->created_at->format('d/m/Y');
                            @endphp
                            <a href="{{ url($locale.'/blogs/'.$rec->slug) }}"
                               class="d-flex align-items-center gap-3 mb-3 text-decoration-none text-dark">
                                @if($recImg)
                                <img src="{{ $recImg }}" alt=""
                                     style="width:70px;height:60px;object-fit:cover;border-radius:8px;flex-shrink:0;">
                                @endif
                                <div>
                                    <p class="mb-0 small fw-semibold">{{ Str::limit($recTitle, 55) }}</p>
                                    <span class="small muted-color">{{ $recDate }}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection
