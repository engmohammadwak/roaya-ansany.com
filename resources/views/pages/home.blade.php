@extends('layouts.app')
@section('title', __('nav.home'))

@section('content')
    {{-- Hero Section --}}
    <section class="hero">
        <h1>{{ Setting::get('hero_title_' . app()->getLocale()) }}</h1>
        <p>{{ Setting::get('hero_subtitle_' . app()->getLocale()) }}</p>
        <a href="{{ route('donate', app()->getLocale()) }}">{{ __('general.donate_now') }}</a>
    </section>

    {{-- Campaigns Section --}}
    @if($campaigns->count())
    <section class="campaigns">
        <h2>{{ __('general.latest_campaigns') }}</h2>
        <div class="campaigns-grid">
            @foreach($campaigns as $campaign)
            <div class="campaign-card">
                <img src="{{ $campaign->image_url }}" alt="{{ $campaign->title }}">
                <h3>{{ $campaign->title }}</h3>
                <p>{{ Str::limit($campaign->description, 100) }}</p>
                <div class="progress">
                    <div class="progress-bar" style="width: {{ $campaign->progress_percentage }}%"></div>
                </div>
                <span>{{ $campaign->progress_percentage }}%</span>
                <a href="{{ route('campaigns.show', [app()->getLocale(), $campaign->id]) }}">{{ __('general.read_more') }}</a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Blogs Section --}}
    @if($blogs->count())
    <section class="blogs">
        <h2>{{ __('general.latest_blogs') }}</h2>
        <div class="blogs-grid">
            @foreach($blogs as $blog)
            <div class="blog-card">
                <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}">
                <h3>{{ $blog->title }}</h3>
                <p>{{ $blog->excerpt }}</p>
                <a href="{{ route('blogs.show', [app()->getLocale(), $blog->slug]) }}">{{ __('general.read_more') }}</a>
            </div>
            @endforeach
        </div>
    </section>
    @endif
@endsection
