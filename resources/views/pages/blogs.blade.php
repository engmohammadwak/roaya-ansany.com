@extends('layouts.app')

@section('title', __('pages.blogs.title'))

@section('content')
<div style="max-width:1200px; margin:40px auto; padding:0 20px;">

    <h1 class="MuiTypography-root" style="margin-bottom:32px;">{{ __('pages.blogs.title') }}</h1>

    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:24px;">
        @forelse($blogs['data'] ?? [] as $blog)
        <div style="border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08);">
            <a href="{{ route('blogs.show', [app()->getLocale(), $blog['slug'] ?? $blog['id']]) }}"
               style="text-decoration:none; display:block; height:200px; overflow:hidden;">
                <img src="{{ $blog['image'] ?? '' }}" alt="{{ $blog['title'] ?? '' }}"
                     style="width:100%; height:200px; object-fit:cover;">
            </a>
            <div style="padding:16px;">
                <a href="{{ route('blogs.show', [app()->getLocale(), $blog['slug'] ?? $blog['id']]) }}"
                   style="text-decoration:none;">
                    <h3 style="font-size:16px; margin-bottom:8px;">{{ $blog['title'] ?? '' }}</h3>
                </a>
                <p style="color:#888; font-size:14px; line-height:1.6;">
                    {{ Str::limit(strip_tags($blog['excerpt'] ?? $blog['content'] ?? ''), 120) }}
                </p>
                <p style="color:#aaa; font-size:12px; margin-top:8px;">{{ $blog['created_at'] ?? '' }}</p>
            </div>
        </div>
        @empty
        <p style="text-align:center; color:#888; padding:60px; grid-column:1/-1;">{{ __('blogs.no_blogs') }}</p>
        @endforelse
    </div>
</div>
@endsection
