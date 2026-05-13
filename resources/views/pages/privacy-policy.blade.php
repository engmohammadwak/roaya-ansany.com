@extends('layouts.app')
@section('body_class', 'privacy')

@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';
@endphp
@section('title', ($isAr ? 'سياسة الخصوصية' : 'Privacy Policy') . ' | ' . config('app.name'))

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
                {{ $isAr ? 'سياسة الخصوصية' : 'Privacy Policy' }}
            </a>
        </div>

        <div class="intro-float mt-5">
            <h1 class="title mt-4">
                {{ $isAr ? 'سياسة الخصوصية' : 'Privacy Policy' }}
                <img class="ms-4 mt-3 d-none d-lg-inline"
                     src="{{ asset('website/images/orange.svg') }}" alt="">
            </h1>
            <p class="desc mt-4">
                {{ $isAr
                    ? 'نلتزم بحماية خصوصيتك وبياناتك الشخصية وفق أعلى معايير الأمان والشفافية.'
                    : 'We are committed to protecting your privacy and personal data with the highest standards of security and transparency.' }}
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

            @if(isset($policy) && $policy)

                @if($policy->last_updated)
                <p class="muted-color mb-4" style="font-size:.85rem;">
                    {{ $isAr ? 'آخر تحديث:' : 'Last updated:' }}
                    {{ $policy->last_updated->format('d/m/Y') }}
                </p>
                @endif

                @if($policy->sections && $policy->sections->count())
                    @foreach($policy->sections as $section)
                    <div class="content">
                        <h5 class="title">
                            {{ $isAr ? $section->title_ar : ($section->title_en ?: $section->title_ar) }}
                        </h5>
                        <p>
                            {{ $isAr ? $section->body_ar : ($section->body_en ?: $section->body_ar) }}
                        </p>
                    </div>
                    @endforeach
                @elseif($policy->content_ar || $policy->content_en)
                    <div class="content">
                        {!! $isAr ? $policy->content_ar : $policy->content_en !!}
                    </div>
                @else
                    <div class="text-center py-5 muted-color">
                        {{ $isAr ? 'لا يوجد محتوى حالياً.' : 'No content available yet.' }}
                    </div>
                @endif

            @else
                <div class="text-center py-5 muted-color">
                    {{ $isAr ? 'لا يوجد محتوى حالياً.' : 'No content available yet.' }}
                </div>
            @endif

        </div>
    </section>
</div>

@endsection
