@extends('layouts.app')
@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';
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

            <div class="col-md-8 col-lg-6 mx-auto text-center">
                <h1 class="mt-3 mb-4 section-title fw-meduim text-center">
                    {{ $heroTitle }}
                </h1>
                <p class="color-67 text-center">
                    {{ $heroDesc }}
                </p>
            </div>

        </div>
    </section>

    {{-- ===== CAMPAIGNS GRID ===== --}}
    <section class="mt-5">
        <div class="container">
            <div class="row g-4">

                @forelse($campaigns as $campaign)
                @php
                    $campaignUrl = url($locale . '/campaigns/' . ($campaign->slug ?? $campaign->id));
                @endphp
                    <div class="col-12 col-md-6 col-lg-4 d-flex flex-column align-items-center" data-aos="zoom-in">
                        <div class="campaign-card">
                            <a href="{{ $campaignUrl }}" class="blog-card">

                                <img src="{{ $campaign->image_url }}"
                                     alt="{{ $campaign->title }}" class="img-fluid mb-0">

                                <div class="categs mt-3">
                                    <span class="main-color">اغاثة</span>
                                    <span>.</span>
                                    <span class="color-67">
                                        @if($campaign->end_date)
                                            {{ $isAr ? 'ينتهي' : 'Ends' }}: {{ $campaign->end_date->format('d/m/Y') }}
                                        @endif
                                    </span>
                                </div>

                                <div class="title">
                                    <h3 class="dark-text-color mt-2">{{ $campaign->title }}</h3>
                                </div>

                                <div class="progress-container mt-4">
                                    <div class="progress-bar gray">
                                        <div style="width: {{ $campaign->progress_percentage }}%;" class="progress-fill"></div>
                                    </div>
                                </div>

                                <div class="card-footer mt-3">
                                    <input type="text" name="amount" id="amount{{ $campaign->id }}"
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

            @if($campaigns->hasPages())
                <div class="d-flex justify-content-center align-items-center gap-2 mt-5 flex-wrap">
                    @if($campaigns->onFirstPage())
                        <span class="btn btn-light disabled px-4 py-2">{{ $isAr ? 'السابق' : 'Previous' }}</span>
                    @else
                        <a href="{{ $campaigns->previousPageUrl() }}" class="btn btn-outline-primary px-4 py-2">{{ $isAr ? 'السابق' : 'Previous' }}</a>
                    @endif
                    <span class="mx-2 text-muted">{{ $isAr ? 'صفحة' : 'Page' }} {{ $campaigns->currentPage() }} {{ $isAr ? 'من' : 'of' }} {{ $campaigns->lastPage() }}</span>
                    @if($campaigns->hasMorePages())
                        <a href="{{ $campaigns->nextPageUrl() }}" class="btn btn-outline-primary px-4 py-2">{{ $isAr ? 'التالي' : 'Next' }}</a>
                    @else
                        <span class="btn btn-light disabled px-4 py-2">{{ $isAr ? 'التالي' : 'Next' }}</span>
                    @endif
                </div>
            @endif

        </div>
    </section>

</div>

@endsection
