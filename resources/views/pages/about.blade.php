@extends('layouts.app')
@section('title', __('nav.about'))

@section('content')
<section class="about-page">
    <h1>{{ __('nav.about') }}</h1>
    <div class="about-content">
        {!! Setting::get('about_text_' . app()->getLocale()) !!}
    </div>
</section>
@endsection
