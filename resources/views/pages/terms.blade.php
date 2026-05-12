@extends('layouts.app')
@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';

    $bannerTitle = $isAr
        ? ($terms?->banner_title_ar ?: 'شروطنا وأحكامنا…')
        : ($terms?->banner_title_en ?: 'Our Terms & Conditions…');

    $bannerDesc = $isAr
        ? ($terms?->banner_desc_ar ?: 'نضع هذه الشروط والأحكام لتوضيح حقوقك وواجباتك أثناء استخدام خدماتنا.')
        : ($terms?->banner_desc_en ?: 'These terms clarify your rights and responsibilities when using our services.');
@endphp
@section('title', ($isAr ? 'الشروط والأحكام' : 'Terms of Use') . ' | ' . config('app.name'))

@section('content')

{{-- ===== BANNER ===== --}}
<section class="blank-banner first-container">
    <div class="container">

        <div class="breadcrumbs">
            <a href="{{ url($locale) }}">
                <img class="me-2" src="{{ asset('website/images/home.svg') }}" alt="home">
                {{ $isAr ? 'الرئيسية' : 'Home' }}
            </a>
            <span>/</span>
            <a href="#" class="active">
                {{ $isAr ? 'القواعد والأحكام' : 'Terms of Use' }}
            </a>
        </div>

        <div class="intro-float mt-5">
            <h1 class="title mt-4">
                {!! $bannerTitle !!}
                <img class="ms-4 mt-3 d-none d-lg-inline"
                     src="{{ asset('website/images/orange.svg') }}" alt="">
            </h1>
            <p class="desc mt-4">
                {{ $bannerDesc }}
                <img class="ms-4 mt-3 d-none d-lg-inline"
                     src="{{ asset('website/images/blue.svg') }}" alt="">
            </p>
        </div>

    </div>
</section>

{{-- ===== CONTENT ===== --}}
<div class="float-section-container">
    <section class="float-section terms-float-section">
        <div class="container">

            @if($terms?->last_updated)
            <p class="muted-color mb-4" style="font-size:.85rem;">
                {{ $isAr ? 'آخر تحديث:' : 'Last updated:' }}
                {{ $terms->last_updated->format('d/m/Y') }}
            </p>
            @endif

            @if($terms && $terms->sections->count())

                @foreach($terms->sections as $section)
                <div class="content">
                    <h5 class="title">
                        {{ $isAr ? $section->title_ar : ($section->title_en ?: $section->title_ar) }}
                    </h5>
                    <p>
                        {{ $isAr ? $section->body_ar : ($section->body_en ?: $section->body_ar) }}
                    </p>
                </div>
                @endforeach

            @elseif($terms && ($terms->content_ar || $terms->content_en))
                {{-- fallback: محتوى قديم --}}
                <div class="content">
                    {!! $isAr ? $terms->content_ar : $terms->content_en !!}
                </div>

            @else
                <div class="text-center py-5 muted-color">
                    {{ $isAr ? 'لا يوجد محتوى حالياً.' : 'No content available yet.' }}
                </div>
            @endif

        </div>
    </section>
</div>

@endsection
