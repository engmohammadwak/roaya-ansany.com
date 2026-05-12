@extends('layouts.app')

@section('title', __('pages.donate.title'))

@section('content')
<div style="max-width:1200px; margin:40px auto; padding:0 20px;">
    <h1 class="MuiTypography-root" style="margin-bottom:32px;">{{ __('pages.donate.title') }}</h1>

    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:24px;">
        @forelse($projects['data'] ?? [] as $project)
        <div style="border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); padding:20px;">
            <h3 style="margin-bottom:16px;">{{ $project['title'] ?? '' }}</h3>

            {{-- Currency --}}
            <label style="font-size:13px; display:block; margin-bottom:6px;">{{ __('donate.currency') }}</label>
            <select style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; margin-bottom:16px; font-family:inherit;">
                <option>USD</option>
                <option>OMR</option>
                <option>SAR</option>
                <option>AED</option>
            </select>

            {{-- Amount Buttons --}}
            <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px;">
                @foreach([10, 25, 50, 100, 250] as $amount)
                <button type="button"
                        class="MuiButtonBase-root MuiButton-root MuiButton-outlined MuiButton-outlinedInherit muirtl-18b7cl4"
                        onclick="document.getElementById('amount-{{ $project['id'] }}').value={{ $amount }}"
                        style="padding:6px 14px; border-radius:6px; border:1px solid #ddd; cursor:pointer; font-family:inherit;">
                    {{ $amount }}
                </button>
                @endforeach
            </div>

            {{-- Custom Amount --}}
            <input type="number" id="amount-{{ $project['id'] }}" value="10" placeholder="{{ __('donate.amount') }}"
                   style="width:100%; padding:10px 14px; border:1px solid #ddd; border-radius:6px; margin-bottom:16px; font-family:inherit;">

            <a href="https://app.tujuhbulir.com/projects/{{ $project['id'] }}"
               target="_blank"
               class="MuiButtonBase-root MuiButton-root MuiButton-contained MuiButton-containedInherit MuiButton-fullWidth muirtl-zqbx1x"
               style="display:flex; align-items:center; justify-content:center; gap:8px; padding:12px; text-decoration:none;">
                <img src="{{ asset('assets/donate.svg') }}" alt="donate" class="icon-white" style="width:18px;">
                {{ __('projects.donate_now') }}
            </a>
        </div>
        @empty
        <p style="color:#888; text-align:center; grid-column:1/-1; padding:60px;">{{ __('projects.no_projects') }}</p>
        @endforelse
    </div>
</div>
@endsection
