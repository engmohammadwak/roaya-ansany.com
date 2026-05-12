@extends('layouts.app')
@section('title', $blog->title)

@section('content')
<article class="blog-single">
    <h1>{{ $blog->title }}</h1>
    @if($blog->image)
        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}">
    @endif
    <div class="content">{!! $blog->content !!}</div>
</article>

@if($related->count())
<section class="related-blogs">
    <h2>{{ __('general.related_blogs') }}</h2>
    <div class="blogs-grid">
        @foreach($related as $item)
        <div class="blog-card">
            <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
            <h3>{{ $item->title }}</h3>
            <a href="{{ route('blogs.show', [app()->getLocale(), $item->slug]) }}">{{ __('general.read_more') }}</a>
        </div>
        @endforeach
    </div>
</section>
@endif
@endsection
