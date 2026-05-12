@extends('layouts.app')
@php $locale = app()->getLocale(); $isAr = $locale === 'ar'; @endphp
@section('title', ($isAr ? 'الأسئلة الشائعة' : 'FAQs') . ' | مؤسسة رؤيا الإنسانية')
@push('styles')
<style>
.faq-hero { background: linear-gradient(135deg,#1a7a4a,#2ecc71); padding:100px 0 60px; color:#fff; text-align:center; }
.faq-hero h1 { font-size:2.5rem; font-weight:700; }
.faq-section { padding:70px 0; }
.faq-category-title { font-size:1.3rem; font-weight:700; color:#1a7a4a; margin:40px 0 20px; padding-bottom:10px; border-bottom:2px solid #d4edda; }
.faq-item { background:#fff; border-radius:12px; margin-bottom:12px; box-shadow:0 2px 12px rgba(0,0,0,.06); overflow:hidden; }
.faq-question { padding:20px 25px; font-weight:600; color:#222; cursor:pointer; display:flex; justify-content:space-between; align-items:center; transition:background .2s; }
.faq-question:hover { background:#f0faf5; }
.faq-question .faq-icon { color:#1a7a4a; font-size:1.3rem; transition:transform .3s; }
.faq-question[aria-expanded="true"] .faq-icon { transform:rotate(45deg); }
.faq-answer { padding:0 25px; color:#555; line-height:1.8; }
.faq-answer.show { padding:5px 25px 20px; }
.breadcrumb-section { background:#f0faf5; padding:12px 0; border-bottom:1px solid #d4edda; }
.breadcrumb-section a { color:#1a7a4a; text-decoration:none; }
</style>
@endpush
@section('content')
<div class="breadcrumb-section">
    <div class="container"><small><a href="{{ url($locale.'/') }}">{{ $isAr?'الرئيسية':'Home' }}</a><span style="margin:0 8px;color:#888">›</span><span class="text-muted">{{ $isAr?'الأسئلة الشائعة':'FAQs' }}</span></small></div>
</div>
<section class="faq-hero">
    <div class="container">
        <h1>{{ $isAr ? 'الأسئلة الشائعة' : 'Frequently Asked Questions' }}</h1>
        <p style="opacity:.9;margin-top:10px">{{ $isAr ? 'إجابات على أكثر الأسئلة شيوعاً' : 'Answers to the most common questions' }}</p>
    </div>
</section>
<section class="faq-section">
    <div class="container" style="max-width:860px">
        @forelse($categories as $cat)
            <h2 class="faq-category-title">{{ $isAr ? $cat->name_ar : $cat->name_en }}</h2>
            @foreach($cat->faqs as $faq)
            <div class="faq-item">
                <button class="faq-question w-100 text-{{ $isAr?'end':'start' }} border-0 bg-transparent"
                    data-bs-toggle="collapse" data-bs-target="#faq-{{ $faq->id }}" aria-expanded="false">
                    {{ $isAr ? $faq->question_ar : $faq->question_en }}
                    <span class="faq-icon">+</span>
                </button>
                <div id="faq-{{ $faq->id }}" class="collapse faq-answer">
                    {!! $isAr ? $faq->answer_ar : $faq->answer_en !!}
                </div>
            </div>
            @endforeach
        @empty
            @foreach($faqs as $faq)
            <div class="faq-item">
                <button class="faq-question w-100 text-{{ $isAr?'end':'start' }} border-0 bg-transparent"
                    data-bs-toggle="collapse" data-bs-target="#faq-{{ $faq->id }}" aria-expanded="false">
                    {{ $isAr ? $faq->question_ar : $faq->question_en }}
                    <span class="faq-icon">+</span>
                </button>
                <div id="faq-{{ $faq->id }}" class="collapse faq-answer">
                    {!! $isAr ? $faq->answer_ar : $faq->answer_en !!}
                </div>
            </div>
            @endforeach
        @endforelse
        @if($categories->isEmpty() && $faqs->isEmpty())
        <div class="text-center py-5 text-muted">{{ $isAr?'لا توجد أسئلة حالياً':'No FAQs available' }}</div>
        @endif
    </div>
</section>
@endsection
