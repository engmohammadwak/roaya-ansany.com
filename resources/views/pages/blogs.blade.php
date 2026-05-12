@extends('layouts.app')
@section('title', __('nav.blogs'))

@section('content')
<section class="blogs-page">
    <h1>{{ __('nav.blogs') }}</h1>
    <div class="blogs-grid">
        @forelse($blogs as $blog)
        <div class="blog-card">
            <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}">
            <h3>{{ $blog->title }}</h3>
            <p>{{ $blog->excerpt }}</p>
            <a href="{{ route('blogs.show', [app()->getLocale(), $blog->slug]) }}">{{ __('general.read_more') }}</a>
        </div>
        @empty
        <p>{{ __('general.no_blogs') }}</p>
        @endforelse
    </div>
    {{ $blogs->links() }}
</section>
@endsection
