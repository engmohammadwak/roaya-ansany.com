@extends('layouts.app')
@section('title', __('nav.terms'))

@section('content')
<section class="static-page">
    <h1>{{ __('nav.terms') }}</h1>
    <div>{!! Setting::get('terms_' . app()->getLocale()) !!}</div>
</section>
@endsection
