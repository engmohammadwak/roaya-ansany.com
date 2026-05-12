@extends('layouts.app')
@php $locale = app()->getLocale(); $isAr = $locale === 'ar'; @endphp
@section('title', ($isAr ? 'شروط الاستخدام' : 'Terms of Use') . ' | مؤسسة رؤيا الإنسانية')
@push('styles')
<style>
.policy-hero { background:linear-gradient(135deg,#1a7a4a,#2ecc71); padding:100px 0 60px; color:#fff; text-align:center; }
.policy-hero h1 { font-size:2.5rem; font-weight:700; }
.policy-section { padding:70px 0; background:#fff; }
.policy-content { max-width:860px; margin:0 auto; font-size:1.05rem; line-height:2; color:#444; }
.policy-content h2, .policy-content h3 { color:#1a7a4a; margin-top:35px; margin-bottom:12px; }
.policy-updated { background:#f0faf5; border-right:4px solid #1a7a4a; padding:12px 20px; border-radius:8px; margin-bottom:30px; color:#555; font-size:.9rem; }
.breadcrumb-section { background:#f0faf5; padding:12px 0; border-bottom:1px solid #d4edda; }
.breadcrumb-section a { color:#1a7a4a; text-decoration:none; }
</style>
@endpush
@section('content')
<div class="breadcrumb-section">
    <div class="container"><small><a href="{{ url($locale.'/') }}">{{ $isAr?'الرئيسية':'Home' }}</a><span style="margin:0 8px;color:#888">›</span><span class="text-muted">{{ $isAr?'شروط الاستخدام':'Terms of Use' }}</span></small></div>
</div>
<section class="policy-hero">
    <div class="container">
        <h1>{{ $isAr ? ($terms?->title_ar ?? 'شروط الاستخدام') : ($terms?->title_en ?? 'Terms of Use') }}</h1>
    </div>
</section>
<section class="policy-section">
    <div class="container">
        <div class="policy-content">
            @if($terms?->last_updated)
            <div class="policy-updated">{{ $isAr?'آخر تحديث:':'Last updated:' }} {{ $terms->last_updated->format('Y-m-d') }}</div>
            @endif
            @if($terms)
                {!! $isAr ? $terms->content_ar : $terms->content_en !!}
            @else
            <div class="text-center py-5 text-muted">{{ $isAr?'المحتوى غير متاح حالياً':'Content not available yet' }}</div>
            @endif
        </div>
    </div>
</section>
@endsection
