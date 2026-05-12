@extends('layouts.app')
@section('title', __('nav.privacy'))

@section('content')
<section class="static-page">
    <h1>{{ __('nav.privacy') }}</h1>
    <div>{!! Setting::get('privacy_policy_' . app()->getLocale()) !!}</div>
</section>
@endsection
