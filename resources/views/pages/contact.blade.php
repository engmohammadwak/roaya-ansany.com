@extends('layouts.app')

@section('title', __('pages.contact.title'))

@section('content')
<div style="max-width:700px; margin:60px auto; padding:0 20px;">
    <h1 class="MuiTypography-root" style="margin-bottom:32px;">{{ __('pages.contact.title') }}</h1>

    @if(session('success'))
    <div style="background:#e8f5e9; color:#2e7d32; padding:16px; border-radius:8px; margin-bottom:24px;">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div style="background:#ffebee; color:#c62828; padding:16px; border-radius:8px; margin-bottom:24px;">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('contact.store', app()->getLocale()) }}"
          style="display:flex; flex-direction:column; gap:20px;">
        @csrf

        <div>
            <label style="display:block; margin-bottom:6px; font-size:14px;">{{ __('contact.name') }}</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="MuiInputBase-input MuiOutlinedInput-input muirtl-cfvh16"
                   style="width:100%; padding:12px 14px; border:1px solid #ddd; border-radius:6px; font-family:inherit;">
        </div>

        <div>
            <label style="display:block; margin-bottom:6px; font-size:14px;">{{ __('contact.email') }}</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="MuiInputBase-input MuiOutlinedInput-input muirtl-cfvh16"
                   style="width:100%; padding:12px 14px; border:1px solid #ddd; border-radius:6px; font-family:inherit;">
        </div>

        <div>
            <label style="display:block; margin-bottom:6px; font-size:14px;">{{ __('contact.message') }}</label>
            <textarea name="message" rows="6"
                      class="MuiInputBase-input MuiOutlinedInput-input muirtl-cfvh16"
                      style="width:100%; padding:12px 14px; border:1px solid #ddd; border-radius:6px; font-family:inherit; resize:vertical;">{{ old('message') }}</textarea>
        </div>

        <button type="submit"
                class="MuiButtonBase-root MuiButton-root MuiButton-contained MuiButton-containedInherit MuiButton-fullWidth muirtl-zqbx1x"
                style="padding:14px;">
            {{ __('contact.submit') }}
        </button>
    </form>
</div>
@endsection
