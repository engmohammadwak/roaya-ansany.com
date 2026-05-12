@php
    $siteName    = App\Models\Setting::get('site_name',    'مؤسسة رؤيا الإنسانية');
    $siteFavicon = App\Models\Setting::get('site_favicon', 'https://roaya-ansany.com/website/fav/favicon.ico');
    $primary   = App\Models\Setting::get('primary_color',   '#9dcc6b');
    $secondary = App\Models\Setting::get('secondary_color', '#2F7BC1');
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'ساهم في إنقاذ الأرواح ودعم المحتاجين عبر حملات مؤسسة رؤيا الإنسانية.')">
    <title>@yield('title', $siteName)</title>

    <link rel="icon" href="{{ $siteFavicon }}">
    <link rel="shortcut icon" href="{{ $siteFavicon }}">
    <link rel="apple-touch-icon" href="{{ $siteFavicon }}">

    {{-- حقن الألوان الديناميكية — تغطي كل :root في main.css --}}
    <style>
        :root {
            --main-color:        {{ $primary }};
            --main-color-hover:  #fff;
            --secondary-color:   {{ $secondary }};
            /* gradient helpers */
            --grad-primary-15:   color-mix(in srgb, {{ $primary }} 15%, transparent);
            --grad-secondary-15: color-mix(in srgb, {{ $secondary }} 15%, transparent);
        }
        /* gradient overrides — يستبدل كل linear-gradient الثابت */
        .hero-banner,
        .stats .change-life,
        .page-banner.main,
        .donate-section .campaign-section .donation-card {
            background: linear-gradient(135deg,
                color-mix(in srgb, {{ $secondary }} 15%, transparent),
                color-mix(in srgb, {{ $primary }}   15%, transparent)
            ) !important;
        }
        .stats-card {
            background: linear-gradient(135deg,
                color-mix(in srgb, {{ $secondary }} 90%, transparent),
                color-mix(in srgb, {{ $primary }}   90%, transparent)
            ) !important;
        }
        .main-section .donate {
            background: linear-gradient(135deg,
                color-mix(in srgb, {{ $secondary }} 92%, transparent),
                {{ $primary }}
            ) !important;
        }
        main.campaign .blank-banner {
            background: linear-gradient(135deg, {{ $primary }}, color-mix(in srgb, {{ $secondary }} 92%, transparent)) !important;
        }
        .page-banner.main h1.bg {
            background: color-mix(in srgb, {{ $primary }} 28%, transparent) !important;
        }
        .progress-fill { background-color: {{ $primary }} !important; }
        .btn-outline-primary {
            color: {{ $primary }} !important;
            border-color: {{ $primary }} !important;
        }
        .btn-outline-primary:hover {
            background-color: {{ $primary }} !important;
            border-color: {{ $primary }} !important;
        }
    </style>

    <link href="https://roaya-ansany.com/website/libs/bootstrap/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://roaya-ansany.com/website/libs/slimselect/slimselect.css" rel="stylesheet">
    <link rel="stylesheet" href="https://roaya-ansany.com/website/css/main.css?v=2">

    @stack('styles')
</head>
<body>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://roaya-ansany.com/website/libs/slimselect/slimselect.js"></script>
    <script src="https://roaya-ansany.com/website/libs/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="https://roaya-ansany.com/website/js/main.js" defer></script>

    <script>
    window.addEventListener("scroll", function () {
        const navbar = document.querySelector(".main-navbar");
        if (navbar) {
            if (window.scrollY > 30) navbar.classList.add("scrolled");
            else navbar.classList.remove("scrolled");
        }
    });
    const scrollBtn = document.getElementById("scrollTopBtn");
    if (scrollBtn) {
        window.addEventListener("scroll", function () {
            scrollBtn.style.display = window.scrollY > 250 ? "flex" : "none";
        });
        scrollBtn.addEventListener("click", function () {
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    }
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-donate');
        if (!btn) return;
        e.preventDefault();
        function findAmount(startEl) {
            let parent = startEl.parentElement;
            while (parent && parent !== document.body) {
                const found = parent.querySelector('input[name="amount"], input.form-input');
                if (found) return found;
                parent = parent.parentElement;
            }
            return null;
        }
        const inp = findAmount(btn);
        const amount = inp ? inp.value.trim() : '';
        const base = "{{ url(app()->getLocale() . '/donate') }}";
        window.location.href = amount ? `${base}?amount=${encodeURIComponent(amount)}` : base;
    });
    document.addEventListener('input', function (e) {
        if (e.target.name === 'amount') {
            let val = e.target.value.replace(/[^0-9.]/g, '');
            const parts = val.split('.');
            if (parts.length > 2) val = parts[0] + '.' + parts.slice(1).join('');
            e.target.value = val;
        }
    });
    </script>

    @php $wa = App\Models\Setting::get('whatsapp_number', '905398863777'); @endphp
    <a href="https://api.whatsapp.com/send/?phone={{ $wa }}&text={{ urlencode('مرحباً بك في مؤسسة رؤيا الإنسانية') }}"
       target="_blank" class="whatsapp-float" aria-label="WhatsApp">
        <svg fill="#fff" width="30px" height="30px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <path d="M26.576 5.363c-2.69-2.69-6.406-4.354-10.511-4.354-8.209 0-14.865 6.655-14.865 14.865 0 2.732 0.737 5.291 2.022 7.491l-0.038-0.070-2.109 7.702 7.879-2.067c2.051 1.139 4.498 1.809 7.102 1.809h0.006c8.209-0.003 14.862-6.659 14.862-14.868 0-4.103-1.662-7.817-4.349-10.507l0 0zM16.062 28.228h-0.005c-2.319 0-4.489-0.64-6.342-1.753l0.056 0.031-0.451-0.267-4.675 1.227 1.247-4.559-0.294-0.467c-1.185-1.862-1.889-4.131-1.889-6.565 0-6.822 5.531-12.353 12.353-12.353s12.353 5.531 12.353 12.353c0 6.822-5.53 12.353-12.353 12.353h-0z"/>
        </svg>
    </a>

    <button id="scrollTopBtn" class="scroll-top-float" aria-label="Scroll to top" style="display:none;">↑</button>

    @stack('scripts')
</body>
</html>
