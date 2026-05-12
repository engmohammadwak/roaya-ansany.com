@extends('layouts.app')
@section('title', __('nav.contact'))

@section('content')
<section class="contact-page">
    <h1>{{ __('nav.contact') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('contact.store', app()->getLocale()) }}" method="POST">
        @csrf
        <div>
            <label>{{ __('general.name') }}</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>{{ __('general.email') }}</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>{{ __('general.phone') }}</label>
            <input type="text" name="phone" value="{{ old('phone') }}">
        </div>
        <div>
            <label>{{ __('general.message') }}</label>
            <textarea name="message" rows="5" required>{{ old('message') }}</textarea>
            @error('message') <span>{{ $message }}</span> @enderror
        </div>
        <button type="submit">{{ __('general.send') }}</button>
    </form>

    <div class="contact-info">
        @if(Setting::get('site_email'))
            <p>{{ Setting::get('site_email') }}</p>
        @endif
        @if(Setting::get('site_phone'))
            <p>{{ Setting::get('site_phone') }}</p>
        @endif
        @if(Setting::get('site_address_' . app()->getLocale()))
            <p>{{ Setting::get('site_address_' . app()->getLocale()) }}</p>
        @endif
    </div>
</section>
@endsection
