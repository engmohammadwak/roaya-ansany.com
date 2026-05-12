@extends('layouts.app')
@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';

    // ApiService returns an array like:
    // ['data' => [...], 'meta' => ['current_page'=>1,'last_page'=>3,'total'=>27]]
    // Fallback: if it returns a plain array treat it directly
    $items       = is_array($campaigns) && isset($campaigns['data']) ? $campaigns['data'] : (is_array($campaigns) ? $campaigns : []);
    $meta        = is_array($campaigns) && isset($campaigns['meta'])  ? $campaigns['meta']  : [];
    $currentPage = $meta['current_page'] ?? request('page', 1);
    $lastPage    = $meta['last_page']    ?? 1;
    $prevUrl     = $currentPage > 1      ? url($locale . '/campaigns?page=' . ($currentPage - 1)) : null;
    $nextUrl     = $currentPage < $lastPage ? url($locale . '/campaigns?page=' . ($currentPage + 1)) : null;
@endphp
@section('title', ($isAr ? 'الحملات الإنسانية' : 'Humanitarian Campaigns') . ' | ' . config('app.name'))

@section('content')

<div class="first-container">

    {{-- ===== INTRO ===== --}}
    <section class="mt-5">
        <div class="container">

            <div class="breadcrumbs justify-content-center mt-4 mb-4">
                <a href="{{ url($locale) }}">
                    <img class="me-2" src="{{ asset('website/images/home.svg') }}" alt="home">
                    {{ $isAr ? 'الرئيسية' : 'Home' }}
                </a>
                <span>/</span>
                <a href="#" class="active">
                    {{ $isAr ? 'الحملات' : 'Campaigns' }}
                </a>
            </div>

            <div class="text-center mx-auto w-60">
                <h1 class="mt-3 mb-4 section-title fw-meduim">
                    {{ $isAr ? 'شارك في صنع الأمل' : 'Be Part of Making Hope' }}
                </h1>
                <p class="color-67">
                    {{ $isAr
                        ? 'اكتشف الحملات الإنسانية وكن جزءًا من التغيير. تبرع اليوم لتمنح المحتاجين فرصة لحياة أفضل.'
                        : 'Discover humanitarian campaigns and be part of the change.'
                    }}
                </p>
            </div>

        </div>
    </section>

    {{-- ===== CAMPAIGNS GRID ===== --}}
    <section class="mt-5">
        <div class="container">
            <div class="row g-4">

                @forelse($items as $campaign)
                    @php
                        // Support both object and array
                        $id         = data_get($campaign, 'id');
                        $title      = $isAr ? data_get($campaign, 'title_ar', data_get($campaign, 'title')) : data_get($campaign, 'title_en', data_get($campaign, 'title'));
                        $slug       = data_get($campaign, 'slug', $id);
                        $image      = data_get($campaign, 'image');
                        $categoryAr = data_get($campaign, 'category_ar', data_get($campaign, 'category', 'اغاثة'));
                        $categoryEn = data_get($campaign, 'category_en', data_get($campaign, 'category', 'Relief'));
                        $locationAr = data_get($campaign, 'location_ar', data_get($campaign, 'location', ''));
                        $locationEn = data_get($campaign, 'location_en', data_get($campaign, 'location', ''));
                        $raised     = data_get($campaign, 'raised_amount', data_get($campaign, 'raised', 0));
                        $goal       = data_get($campaign, 'goal_amount',   data_get($campaign, 'goal',   0));
                        $pct        = ($goal > 0) ? min(100, round(($raised / $goal) * 100)) : 100;
                    @endphp
                    <div class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center" data-aos="zoom-in">
                        <div class="campaign-card">
                            <a href="{{ url($locale . '/campaigns/' . $slug) }}" class="blog-card">

                                @if($image)
                                    <img src="{{ Str::startsWith($image, 'http') ? $image : Storage::url($image) }}"
                                         alt="{{ $title }}" class="img-fluid mb-0">
                                @endif

                                <div class="categs mt-3">
                                    <span class="main-color">{{ $isAr ? $categoryAr : $categoryEn }}</span>
                                    <span>.</span>
                                    <span class="color-67">{{ $isAr ? $locationAr : $locationEn }}</span>
                                </div>

                                <div class="title">
                                    <h3 class="dark-text-color mt-2">{{ $title }}</h3>
                                </div>

                                <div class="progress-container mt-4">
                                    <div class="progress-bar gray">
                                        <div style="width: {{ $pct }}%;" class="progress-fill"></div>
                                    </div>
                                </div>

                                <div class="card-footer mt-3">
                                    <input type="text" name="amount" id="amount{{ $id }}"
                                           class="form-input"
                                           placeholder="{{ $isAr ? 'ادخل مبلغ التبرع' : 'Enter donation amount' }}">
                                    <button type="button" class="btn-donate">
                                        {{ $isAr ? 'تبرع' : 'Donate' }}
                                    </button>
                                </div>

                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="color-67">{{ $isAr ? 'لا توجد حملات حالياً.' : 'No campaigns available at the moment.' }}</p>
                    </div>
                @endforelse

            </div>

            {{-- ===== PAGINATION ===== --}}
            @if($lastPage > 1)
                <div class="d-flex justify-content-center align-items-center gap-2 mt-5 flex-wrap">

                    @if($prevUrl)
                        <a href="{{ $prevUrl }}" class="btn btn-outline-primary px-4 py-2">
                            {{ $isAr ? 'السابق' : 'Previous' }}
                        </a>
                    @else
                        <span class="btn btn-light disabled px-4 py-2">
                            {{ $isAr ? 'السابق' : 'Previous' }}
                        </span>
                    @endif

                    <span class="mx-2 text-muted">
                        {{ $isAr ? 'صفحة' : 'Page' }} {{ $currentPage }}
                        {{ $isAr ? 'من' : 'of' }} {{ $lastPage }}
                    </span>

                    @if($nextUrl)
                        <a href="{{ $nextUrl }}" class="btn btn-outline-primary px-4 py-2">
                            {{ $isAr ? 'التالي' : 'Next' }}
                        </a>
                    @else
                        <span class="btn btn-light disabled px-4 py-2">
                            {{ $isAr ? 'التالي' : 'Next' }}
                        </span>
                    @endif

                </div>
            @endif

        </div>
    </section>

</div>

@endsection
