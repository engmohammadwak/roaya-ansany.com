@extends('layouts.app')
@php
    $locale  = app()->getLocale();
    $isAr    = $locale === 'ar';
    $title   = $isAr ? $post->title_ar : ($post->title_en ?: $post->title_ar);
    $body    = $isAr ? $post->body_ar  : ($post->body_en  ?: $post->body_ar);
    $excerpt = $isAr ? ($post->excerpt_ar ?? '') : ($post->excerpt_en ?? $post->excerpt_ar ?? '');
    $img     = $post->image ? asset('storage/'.$post->image) : null;
    $date    = $post->published_at
               ? $post->published_at->translatedFormat('d F, Y')
               : $post->created_at->translatedFormat('d F, Y');
    $recents = \App\Models\Blog::published()
               ->where('id', '!=', $post->id)
               ->latest()
               ->take(4)
               ->get();
@endphp

@section('title', $title . ' | ' . config('app.name'))
@section('description', Str::limit(strip_tags($excerpt ?: $body), 160))
@section('og_image', $img ?? asset('website/images/og-default.jpg'))

@section('content')
<div class="blog first-container">

    {{-- ── Hero / Title ── --}}
    <section class="mt-5">
        <div class="container">

            {{-- Breadcrumbs --}}
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
                <a href="#" class="active">{{ $isAr ? 'تفاصيل المدونة' : 'Blog Details' }}</a>
            </div>

            {{-- Title --}}
            <div class="text-center mx-auto" style="max-width:780px;">
                <h1 class="mt-3 mb-4 section-title fw-medium">{{ $title }}</h1>
            </div>

            {{-- Hero Image --}}
            @if($img)
            <img class="img-fluid object-fit-cover d-block mx-auto rounded-3 mb-4"
                 src="{{ $img }}" alt="{{ $title }}"
                 data-aos="zoom-in" data-aos-delay="200"
                 style="max-height:480px; width:100%;">
            @endif

        </div>
    </section>

    {{-- ── Content + Sidebar ── --}}
    <section class="content">
        <div class="container">
            <div class="row">

                {{-- ── Main Content --}}
                <div class="col-lg-8 mb-5">

                    {{-- Date --}}
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img width="18" height="18" src="{{ asset('website/images/time.svg') }}" alt="time">
                        <span class="dark-text-color">{{ $date }}</span>
                    </div>

                    {{-- Body --}}
                    <div class="blog-content">
                        {!! $body !!}
                    </div>

                    {{-- Share --}}
                    <div class="d-flex align-items-center gap-3 mt-5 pt-3 border-top">
                        <span class="fw-semibold">{{ $isAr ? 'شارك المقال' : 'Share' }}:</span>
                        @php $shareUrl = urlencode(request()->url()); $shareTitle = urlencode($title); @endphp
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener">
                            <img width="28" src="{{ asset('website/images/facebook.svg') }}" alt="Facebook">
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener">
                            <img width="28" src="{{ asset('website/images/xtwitter.png') }}" alt="X">
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener">
                            <img width="28" src="{{ asset('website/images/whatsapp.svg') }}" alt="WhatsApp"
                                 onerror="this.style.display='none'">
                        </a>
                    </div>

                </div>

                {{-- ── Sidebar --}}
                <div class="col-lg-4">
                    <div style="position:sticky; top:90px;">

                        {{-- Donate CTA --}}
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

                        {{-- Recent Posts --}}
                        @if($recents->isNotEmpty())
                        <div class="why-donate-card">
                            <h5 class="mb-4">{{ $isAr ? 'مقالات حديثة' : 'Recent Articles' }}</h5>
                            @foreach($recents as $rec)
                            @php
                                $recTitle = $isAr ? $rec->title_ar : ($rec->title_en ?: $rec->title_ar);
                                $recImg   = $rec->image ? asset('storage/'.$rec->image) : null;
                                $recDate  = $rec->published_at
                                            ? $rec->published_at->format('d/m/Y')
                                            : $rec->created_at->format('d/m/Y');
                            @endphp
                            <a href="{{ url($locale.'/blogs/'.$rec->slug) }}"
                               class="d-flex align-items-center gap-3 mb-3 text-decoration-none text-dark">
                                @if($recImg)
                                <img src="{{ $recImg }}" alt=""
                                     style="width:70px; height:60px; object-fit:cover; border-radius:8px; flex-shrink:0;">
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
