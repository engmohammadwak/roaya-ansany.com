@extends('layouts.app')
@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';
@endphp
@section('title', ($isAr ? 'الحملات الإنسانية' : 'Humanitarian Campaigns') . ' | ' . config('app.name'))

@section('content')

<div class="first-container">

    {{-- ===== HERO / INTRO ===== --}}
    <section class="mt-5">
        <div class="container">

            {{-- Breadcrumbs --}}
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

            {{-- Intro text --}}
            <div class="text-center mx-auto w-60">
                <h1 class="mt-3 mb-4 section-title fw-meduim">
                    {{ $isAr ? 'شارك في صنع الأمل' : 'Be Part of Making Hope' }}
                </h1>
                <p class="color-67">
                    {{ $isAr
                        ? 'اكتشف الحملات الإنسانية وكن جزءًا من التغيير. تبرع اليوم لتمنح المحتاجين فرصة لحياة أفضل وتكتب قصة جديدة مليئة بالعطاء.'
                        : 'Discover humanitarian campaigns and be part of the change. Donate today to give those in need a chance for a better life.'
                    }}
                </p>
            </div>

        </div>
    </section>

    {{-- ===== CAMPAIGNS GRID ===== --}}
    <section class="mt-5">
        <div class="container">
            <div class="row g-4">

                @forelse($campaigns as $campaign)
                    <div class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center" data-aos="zoom-in">
                        <div class="campaign-card">
                            <a href="{{ url($locale . '/campaigns/' . $campaign->slug) }}" class="blog-card">

                                @if($campaign->image)
                                    <img src="{{ Storage::url($campaign->image) }}"
                                         alt="{{ $isAr ? $campaign->title_ar : $campaign->title_en }}"
                                         class="img-fluid mb-0">
                                @endif

                                <div class="categs mt-3">
                                    <span class="main-color">{{ $isAr ? ($campaign->category_ar ?? 'اغاثة') : ($campaign->category_en ?? 'Relief') }}</span>
                                    <span>.</span>
                                    <span class="color-67">{{ $isAr ? ($campaign->location_ar ?? '') : ($campaign->location_en ?? '') }}</span>
                                </div>

                                <div class="title">
                                    <h3 class="dark-text-color mt-2">
                                        {{ $isAr ? $campaign->title_ar : $campaign->title_en }}
                                    </h3>
                                </div>

                                <div class="progress-container mt-4">
                                    <div class="progress-bar gray">
                                        @php
                                            $pct = ($campaign->goal_amount > 0)
                                                ? min(100, round(($campaign->raised_amount / $campaign->goal_amount) * 100))
                                                : 100;
                                        @endphp
                                        <div style="width: {{ $pct }}%;" class="progress-fill"></div>
                                    </div>

                                    @if($campaign->goal_amount > 0)
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="color-67">
                                                {{ $isAr ? 'تم جمع' : 'Raised' }}:
                                                {{ number_format($campaign->raised_amount) }} {{ session('currency_symbol', '$') }}
                                            </small>
                                            <small class="color-67">
                                                {{ $isAr ? 'الهدف' : 'Goal' }}:
                                                {{ number_format($campaign->goal_amount) }} {{ session('currency_symbol', '$') }}
                                            </small>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-footer mt-3">
                                    <input type="text" name="amount" id="amount{{ $campaign->id }}"
                                           class="form-input"
                                           placeholder="{{ $isAr ? 'ادخل مبلغ التبرع' : 'Enter donation amount' }}">
                                    <button type="button" class="btn-donate"
                                            data-campaign-id="{{ $campaign->id }}">
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
            @if($campaigns->hasPages())
                <div class="d-flex justify-content-center align-items-center gap-2 mt-5 flex-wrap">

                    {{-- Previous --}}
                    @if($campaigns->onFirstPage())
                        <span class="btn btn-light disabled px-4 py-2">
                            {{ $isAr ? 'السابق' : 'Previous' }}
                        </span>
                    @else
                        <a href="{{ $campaigns->previousPageUrl() }}" class="btn btn-outline-primary px-4 py-2">
                            {{ $isAr ? 'السابق' : 'Previous' }}
                        </a>
                    @endif

                    <span class="mx-2 text-muted">
                        {{ $isAr ? 'صفحة' : 'Page' }} {{ $campaigns->currentPage() }}
                        {{ $isAr ? 'من' : 'of' }} {{ $campaigns->lastPage() }}
                    </span>

                    {{-- Next --}}
                    @if($campaigns->hasMorePages())
                        <a href="{{ $campaigns->nextPageUrl() }}" class="btn btn-outline-primary px-4 py-2">
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
