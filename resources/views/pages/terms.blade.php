@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'الشروط والأحكام':'Terms & Conditions') . ' | مؤسسة رؤيا الإنسانية')

@section('content')
<section class="main-section" style="margin-top:80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="section-title mb-5">{{ $locale==='ar'?'الشروط والأحكام':'Terms & Conditions' }}</h1>
                <div class="muted-color" style="line-height:1.9;">
                    @if($locale==='ar')
                    <p>باستخدام موقع مؤسسة رؤيا الإنسانية، فإنك توافق على الشروط والأحكام المنصوص عليها في هذه الصفحة.</p>
                    @else
                    <p>By using the Roaya Insanya website, you agree to the terms and conditions outlined on this page.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
