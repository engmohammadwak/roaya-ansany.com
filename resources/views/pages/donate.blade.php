@extends('layouts.app')
@section('title', __('nav.donate'))

@section('content')
<section class="donate-page">
    <h1>{{ __('nav.donate') }}</h1>
    <p>{{ __('general.donate_description') }}</p>

    @if($campaigns->count())
    <div class="campaigns-list">
        @foreach($campaigns as $campaign)
        <div class="campaign-item">
            <h3>{{ $campaign->title }}</h3>
            <p>{{ Str::limit($campaign->description, 100) }}</p>
            <div class="progress">
                <div class="progress-bar" style="width: {{ $campaign->progress_percentage }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</section>
@endsection
