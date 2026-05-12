@extends('layouts.app')
@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';
    $p      = $privacy;
@endphp
@section('title', ($isAr ? ($p?->title_ar ?? 'سياسة الخصوصية') : ($p?->title_en ?? 'Privacy Policy')) . ' | ' . config('app.name'))

@section('content')

{{-- ── Hero Banner ── --}}
<section class="blank-banner first-container">
    <div class="container">

        <div class="breadcrumbs justify-content-center">
            <a href="{{ url($locale) }}">
                <img class="me-2" src="{{ asset('website/images/home.svg') }}" alt="home">
                {{ $isAr ? 'الرئيسية' : 'Home' }}
            </a>
            <span>/</span>
            <a href="#" class="active">
                {{ $isAr ? ($p?->title_ar ?? 'سياسة الخصوصية') : ($p?->title_en ?? 'Privacy Policy') }}
            </a>
        </div>

        <h1 class="text-center title mt-4">
            {{ $isAr ? ($p?->title_ar ?? 'سياسة الخصوصية') : ($p?->title_en ?? 'Privacy Policy') }}
        </h1>

        @if($p && ($isAr ? $p->hero_subtitle_ar : $p->hero_subtitle_en))
        <p class="desc mt-4 mx-auto text-center">
            {{ $isAr ? $p->hero_subtitle_ar : $p->hero_subtitle_en }}
        </p>
        @endif

    </div>
</section>

{{-- ── Sections ── --}}
@if($p && $p->sections->count())
<div class="float-section-container">
    <section class="float-section">
        <div class="container">
            @foreach($p->sections as $i => $section)
            <div class="content">
                <h5 class="title">{{ ($i + 1) . '. ' . ($isAr ? $section->title_ar : ($section->title_en ?: $section->title_ar)) }}</h5>
                <p>{{ $isAr ? $section->body_ar : ($section->body_en ?: $section->body_ar) }}</p>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endif

{{-- ── Donate CTA ── --}}
@include('partials.donate-cta')

@endsection
