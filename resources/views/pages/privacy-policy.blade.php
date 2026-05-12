@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'سياسة الخصوصية':'Privacy Policy') . ' | مؤسسة رؤيا الإنسانية')

@section('content')
<section class="main-section" style="margin-top:80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="section-title mb-5">{{ $locale==='ar'?'سياسة الخصوصية':'Privacy Policy' }}</h1>
                <div class="muted-color" style="line-height:1.9;">
                    @if($locale==='ar')
                    <p>نحن في مؤسسة رؤيا الإنسانية نلتزم بحماية خصوصية مستخدمينا ومتبرعينا. تصف هذه السياسة كيفية جمع معلوماتك واستخدامها وحمايتها.</p>
                    @else
                    <p>At Roaya Insanya, we are committed to protecting the privacy of our users and donors. This policy describes how we collect, use, and protect your information.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
