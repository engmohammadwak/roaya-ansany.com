@extends('layouts.app')

@section('title', __('pages.campaigns.title'))

@section('content')
<div style="max-width:1200px; margin:40px auto; padding:0 20px;">

    <h1 class="MuiTypography-root" style="margin-bottom:32px;">{{ __('pages.campaigns.title') }}</h1>

    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:24px;">
        @forelse($campaigns['data'] ?? [] as $project)
        <div class="MuiStack-root muirtl-gii6a9" style="border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08);">

            <a href="{{ route('campaigns.show', [app()->getLocale(), $project['id']]) }}"
               style="text-decoration:none; height:200px; display:block;">
                <img src="{{ $project['image'] ?? '' }}" alt="{{ $project['title'] ?? '' }}"
                     style="width:100%; height:200px; object-fit:cover;">
            </a>

            <div style="padding:16px;">
                <a href="{{ route('campaigns.show', [app()->getLocale(), $project['id']]) }}"
                   style="text-decoration:none;">
                    <h3 class="MuiTypography-root muirtl-1l0mb2o">{{ $project['title'] ?? '' }}</h3>
                </a>

                @php
                    $goal = $project['goal_amount'] ?? 1;
                    $raised = $project['raised_amount'] ?? 0;
                    $percent = $goal > 0 ? min(100, round(($raised / $goal) * 100)) : 0;
                @endphp

                <span class="MuiLinearProgress-root MuiLinearProgress-determinate muirtl-d01cuw"
                      role="progressbar" aria-valuenow="{{ $percent }}"
                      style="display:block; margin:12px 0;">
                    <span class="MuiLinearProgress-bar muirtl-118fe6a"
                          style="transform: translateX(-{{ 100 - $percent }}%)"></span>
                </span>

                <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:16px;">
                    <div><p style="color:#888;">{{ __('projects.goal') }}</p><p>{{ number_format($goal) }}</p></div>
                    <div><p style="color:#888;">{{ __('projects.raised') }}</p><p>{{ number_format($raised) }}</p></div>
                    <div><p style="color:#888;">{{ __('projects.remaining') }}</p><p>{{ number_format(max(0, $goal - $raised)) }}</p></div>
                </div>

                <a href="{{ route('donate', app()->getLocale()) }}?project={{ $project['id'] }}"
                   class="MuiButtonBase-root MuiButton-root MuiButton-contained MuiButton-containedInherit MuiButton-fullWidth muirtl-zqbx1x"
                   style="display:flex; align-items:center; justify-content:center; gap:8px;">
                    <img src="{{ asset('assets/donate.svg') }}" alt="donate" class="icon-white" style="width:18px;">
                    {{ __('projects.donate_now') }}
                </a>
            </div>
        </div>
        @empty
        <p style="text-align:center; color:#888; padding:60px; grid-column:1/-1;">{{ __('projects.no_projects') }}</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(isset($campaigns['meta']['last_page']) && $campaigns['meta']['last_page'] > 1)
    <div style="display:flex; justify-content:center; gap:8px; margin-top:40px;">
        @for($i = 1; $i <= $campaigns['meta']['last_page']; $i++)
        <a href="?page={{ $i }}"
           style="padding:8px 16px; border-radius:6px; background:{{ request('page',1) == $i ? '#1a73e8' : '#eee' }}; color:{{ request('page',1) == $i ? '#fff' : '#333' }}; text-decoration:none;">
            {{ $i }}
        </a>
        @endfor
    </div>
    @endif
</div>
@endsection
