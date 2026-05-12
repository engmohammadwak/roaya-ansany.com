@extends('layouts.app')
@section('title', __('nav.campaigns'))

@section('content')
<section class="campaigns-page">
    <h1>{{ __('nav.campaigns') }}</h1>
    <div class="campaigns-grid">
        @forelse($campaigns as $campaign)
        <div class="campaign-card">
            <img src="{{ $campaign->image_url }}" alt="{{ $campaign->title }}">
            <h3>{{ $campaign->title }}</h3>
            <p>{{ Str::limit($campaign->description, 120) }}</p>
            <div class="progress">
                <div class="progress-bar" style="width: {{ $campaign->progress_percentage }}%"></div>
            </div>
            <div class="campaign-meta">
                <span>{{ __('general.collected') }}: ${{ number_format($campaign->collected_amount, 2) }}</span>
                <span>{{ __('general.target') }}: ${{ number_format($campaign->target_amount, 2) }}</span>
            </div>
            <a href="{{ route('campaigns.show', [app()->getLocale(), $campaign->id]) }}">{{ __('general.read_more') }}</a>
        </div>
        @empty
        <p>{{ __('general.no_campaigns') }}</p>
        @endforelse
    </div>
    {{ $campaigns->links() }}
</section>
@endsection
