<!DOCTYPE html>
<html
    dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    lang="{{ app()->getLocale() }}"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('general.site_name')) - {{ Setting::get('site_name_' . app()->getLocale()) }}</title>
    <link rel="icon" href="{{ asset('storage/' . Setting::get('favicon', '')) }}">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('website/css/style.css') }}">
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('website/css/rtl.css') }}">
    @endif
    @stack('styles')
</head>
<body class="locale-{{ app()->getLocale() }}">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- JS --}}
    <script src="{{ asset('website/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
