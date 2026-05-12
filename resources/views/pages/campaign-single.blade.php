@extends('layouts.app')
@section('title', $campaign->title)

@section('content')
<section class="campaign-single">
    <h1>{{ $campaign->title }}</h1>
    @if($campaign->image)
        <img src="{{ $campaign->image_url }}" alt="{{ $campaign->title }}">
    @endif
    <div class="progress">
        <div class="progress-bar" style="width: {{ $campaign->progress_percentage }}%"></div>
    </div>
    <div class="campaign-stats">
        <span>{{ __('general.collected') }}: ${{ number_format($campaign->collected_amount, 2) }}</span>
        <span>{{ __('general.target') }}: ${{ number_format($campaign->target_amount, 2) }}</span>
        <span>{{ $campaign->progress_percentage }}%</span>
    </div>
    <div class="content">{!! $campaign->description !!}</div>
    <a href="{{ route('donate', app()->getLocale()) }}" class="btn-donate">{{ __('general.donate_now') }}</a>
</section>
@endsection
