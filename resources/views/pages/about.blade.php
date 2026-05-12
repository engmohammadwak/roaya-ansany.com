@extends('layouts.app')

@section('title', __('pages.about.title'))

@section('content')
<div style="max-width:1000px; margin:60px auto; padding:0 20px;">
    <h1 class="MuiTypography-root" style="margin-bottom:24px;">{{ __('pages.about.title') }}</h1>

    @if(!empty($data))
        @foreach($data as $section)
        <div style="margin-bottom:40px;">
            @if(isset($section['title']))
            <h2 style="font-size:22px; margin-bottom:12px;">{{ $section['title'] }}</h2>
            @endif
            @if(isset($section['content']))
            <div style="line-height:1.8; color:#444;">{!! $section['content'] !!}</div>
            @endif
            @if(isset($section['image']))
            <img src="{{ $section['image'] }}" alt="about" style="width:100%; border-radius:12px; margin-top:16px;">
            @endif
        </div>
        @endforeach
    @else
        <p style="color:#888;">{{ __('pages.about.no_content') }}</p>
    @endif
</div>
@endsection
