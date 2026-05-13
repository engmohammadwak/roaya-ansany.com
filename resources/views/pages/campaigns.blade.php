@extends('layouts.app')
@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';
@endphp
@section('title', ($isAr ? '\u0627\u0644\u062d\u0645\u0644\u0627\u062a \u0627\u0644\u0625\u0646\u0633\u0627\u0646\u064a\u0629' : 'Humanitarian Campaigns') . ' | ' . config('app.name'))

@section('content')

<div class="first-container">

    {{-- ===== INTRO ===== --}}
    <section class="mt-5">
        <div class="container">

            <div class="breadcrumbs justify-content-center mt-4 mb-4">
                <a href="{{ url($locale) }}">
                    <img class="me-2" src="{{ asset('website/images/home.svg') }}" alt="home">
                    {{ $isAr ? '\u0627\u0644\u0631\u0626\u064a\u0633\u064a\u0629' : 'Home' }}
                </a>
                <span>/</span>
                <a href="#" class="active">
                    {{ $isAr ? '\u0627\u0644\u062d\u0645\u0644\u0627\u062a' : 'Campaigns' }}
                </a>
            </div>

            <div class="text-center mx-auto w-60">
                <h1 class="mt-3 mb-4 section-title fw-meduim">
                    {{ $heroTitle }}
                </h1>
                <p class="color-67">
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
                                    <span class="main-color">\u0627\u063a\u0627\u062b\u0629</span>
                                    <span>.</span>
                                    <span class="color-67">
                                        @if($campaign->end_date)
                                            {{ $isAr ? '\u064a\u0646\u062a\u0647\u064a' : 'Ends' }}: {{ $campaign->end_date->format('d/m/Y') }}
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
                                           placeholder="{{ $isAr ? '\u0627\u062f\u062e\u0644 \u0645\u0628\u0644\u063a \u0627\u0644\u062a\u0628\u0631\u0639' : 'Enter donation amount' }}">
                                    <button type="button" class="btn-donate">
                                        {{ $isAr ? '\u062a\u0628\u0631\u0639' : 'Donate' }}
                                    </button>
                                </div>

                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="color-67">{{ $isAr ? '\u0644\u0627 \u062a\u0648\u062c\u062f \u062d\u0645\u0644\u0627\u062a \u062d\u0627\u0644\u064a\u064b\u0627.' : 'No campaigns available at the moment.' }}</p>
                    </div>
                @endforelse

            </div>

            @if($campaigns->hasPages())
                <div class="d-flex justify-content-center align-items-center gap-2 mt-5 flex-wrap">
                    @if($campaigns->onFirstPage())
                        <span class="btn btn-light disabled px-4 py-2">{{ $isAr ? '\u0627\u0644\u0633\u0627\u0628\u0642' : 'Previous' }}</span>
                    @else
                        <a href="{{ $campaigns->previousPageUrl() }}" class="btn btn-outline-primary px-4 py-2">{{ $isAr ? '\u0627\u0644\u0633\u0627\u0628\u0642' : 'Previous' }}</a>
                    @endif
                    <span class="mx-2 text-muted">{{ $isAr ? '\u0635\u0641\u062d\u0629' : 'Page' }} {{ $campaigns->currentPage() }} {{ $isAr ? '\u0645\u0646' : 'of' }} {{ $campaigns->lastPage() }}</span>
                    @if($campaigns->hasMorePages())
                        <a href="{{ $campaigns->nextPageUrl() }}" class="btn btn-outline-primary px-4 py-2">{{ $isAr ? '\u0627\u0644\u062a\u0627\u0644\u064a' : 'Next' }}</a>
                    @else
                        <span class="btn btn-light disabled px-4 py-2">{{ $isAr ? '\u0627\u0644\u062a\u0627\u0644\u064a' : 'Next' }}</span>
                    @endif
                </div>
            @endif

        </div>
    </section>

</div>

@endsection
