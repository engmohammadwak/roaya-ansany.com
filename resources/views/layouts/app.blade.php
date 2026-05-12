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

    {{-- Bootstrap CSS --}}
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('website/libs/bootstrap/bootstrap.rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('website/libs/bootstrap/bootstrap.min.css') }}">
    @endif

    {{-- SlimSelect CSS --}}
    <link rel="stylesheet" href="{{ asset('website/libs/slimselect/slimselect.css') }}">

    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('website/css/main.css') }}">
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('website/css/main.rtl.css') }}">
    @endif

    @stack('styles')
</head>
<body class="locale-{{ app()->getLocale() }}">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Bootstrap JS --}}
    <script src="{{ asset('website/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>

    {{-- SlimSelect JS --}}
    <script src="{{ asset('website/libs/slimselect/slimselect.js') }}"></script>

    {{-- Main JS --}}
    <script src="{{ asset('website/js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>
