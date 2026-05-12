<!DOCTYPE html>
<html dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', __('app.description'))">
    <title>@yield('title', __('app.name'))</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Slick Carousel --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css">

    {{-- Main CSS from Next.js build --}}
    <link rel="stylesheet" href="{{ asset('_next/static/css/059c8e1669e0c8e7.css') }}">

    @stack('styles')
</head>
<body>

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Main Content --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>

    {{-- Next.js chunks --}}
    <script src="{{ asset('_next/static/chunks/webpack-d36b50b5fb8708d9.js') }}" defer></script>
    <script src="{{ asset('_next/static/chunks/framework-945b357d4a851f4b.js') }}" defer></script>
    <script src="{{ asset('_next/static/chunks/main-37a5d6427119e763.js') }}" defer></script>
    <script src="{{ asset('_next/static/chunks/pages/_app-08bc2f43e8035b26.js') }}" defer></script>

    @stack('scripts')
</body>
</html>
