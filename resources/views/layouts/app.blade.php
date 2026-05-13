@php
    $siteName   = App\Models\Setting::get('site_name', 'مؤسسة رؤيا الإنسانية');
    $faviconRaw = App\Models\Setting::get('site_favicon');
    $favicon    = $faviconRaw ? asset('storage/' . $faviconRaw) : '/website/fav/favicon.ico';

    $p  = App\Models\Setting::get('color_primary',     '#9dcc6b');
    $s  = App\Models\Setting::get('color_secondary',   '#2F7BC1');
    $td = App\Models\Setting::get('color_text_dark',   '#272727');
    $tm = App\Models\Setting::get('color_text_muted',  '#717171');
    $tl = App\Models\Setting::get('color_text_label',  '#444C4E');
    $ph = App\Models\Setting::get('color_placeholder', '#A9A9A9');
    $bb = App\Models\Setting::get('color_bg_body',     '#ffffff');
    $bl = App\Models\Setting::get('color_bg_light',    '#F5F5F5');
    $bc = App\Models\Setting::get('color_bg_card',     '#F8F8FA');
    $cw = App\Models\Setting::get('color_warning',     '#ff8d02');
    $cd = App\Models\Setting::get('color_danger',      '#D9384A');
    $cs = App\Models\Setting::get('color_step_active', '#f26b81');
    $locale = app()->getLocale();
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'ساهم في إنقاذ الأرواح ودعم المحتاجين عبر حملاتنا.')">
    <title>@hasSection('title') @yield('title') | {{ $siteName }} @else {{ $siteName }} @endif</title>
    <link rel="icon" href="{{ $favicon }}">
    <link rel="shortcut icon" href="{{ $favicon }}">
    <link rel="apple-touch-icon" href="{{ $favicon }}">

    <link href="https://roaya-ansany.com/website/libs/bootstrap/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://roaya-ansany.com/website/libs/slimselect/slimselect.css" rel="stylesheet">
    <link rel="stylesheet" href="https://roaya-ansany.com/website/css/main.css?v=3">

    <style>
        :root {
            --main-color:        {{ $p }} !important;
            --main-color-hover:  #fff;
            --secondary-color:   {{ $s }};
            --dark-text-color:   {{ $td }};
            --muted-text-color:  {{ $tm }};
            --color-444:         {{ $tl }};
            --placeholder-color: {{ $ph }};
            --main-warning-color:{{ $cw }};
        }
        body { background-color: {{ $bb }}; }

        html[dir="rtl"] .section-title,
        html[dir="rtl"] .main-section.why-donate .header h2,
        html[dir="rtl"] .main-section.why-donate .header h6 {
            text-align: right !important;
            width: 100% !important;
        }
        html[dir="ltr"] .section-title { text-align: left !important; }

        .main-section.support-section   { background-color: {{ $bl }} !important; }
        .why-donate-card                { background-color: {{ $bc }} !important; }
        .how-to .step-number.active     { background-color: {{ $cs }} !important; border-color: {{ $cs }} !important; }
        .followors .plus, span.plus     { color: {{ $cd }} !important; }

        .hero-banner,
        .stats .change-life,
        .page-banner.main,
        .donate-section .campaign-section .donation-card {
            background: linear-gradient(135deg,
                color-mix(in srgb, {{ $s }} 15%, transparent),
                color-mix(in srgb, {{ $p }} 15%, transparent)
            ) !important;
        }
        .stats-card {
            background: linear-gradient(135deg,
                color-mix(in srgb, {{ $s }} 90%, transparent),
                color-mix(in srgb, {{ $p }} 90%, transparent)
            ) !important;
        }
        .main-section .donate {
            background: linear-gradient(135deg,
                color-mix(in srgb, {{ $s }} 92%, transparent),
                {{ $p }}
            ) !important;
        }
        main.campaign .blank-banner {
            background: linear-gradient(135deg, {{ $p }},
                color-mix(in srgb, {{ $s }} 92%, transparent)
            ) !important;
        }
        .page-banner.main h1.bg {
            background: color-mix(in srgb, {{ $p }} 28%, transparent) !important;
        }
        .progress-fill                    { background-color: {{ $p }} !important; }
        .search-container img             { background-color: {{ $p }} !important; }
        .filter-check:checked+.filter-btn { background: {{ $p }} !important; border-color: {{ $p }} !important; }
        .btn-outline-primary              { color: {{ $p }} !important; border-color: {{ $p }} !important; }
        .btn-outline-primary:hover        { background-color: {{ $p }} !important; border-color: {{ $p }} !important; }
        .numbered-list li:hover span      { background-color: {{ $p }} !important; border-color: {{ $p }} !important; }
        .about-roaya .our-msg             { background-color: {{ $p }} !important; }
        .mobileCarousal .carousel-indicators span.active { background-color: {{ $p }} !important; }
        footer ul li:hover a              { color: {{ $p }} !important; }
        .main-color                       { color: {{ $p }} !important; }

        .btn-donate,
        a.btn-donate,
        button.btn-donate {
            background-color: {{ $p }} !important;
            border-color: {{ $p }} !important;
            color: #fff !important;
        }
        .btn-donate:hover,
        a.btn-donate:hover,
        button.btn-donate:hover {
            background-color: color-mix(in srgb, {{ $p }} 85%, #000) !important;
            border-color: color-mix(in srgb, {{ $p }} 85%, #000) !important;
        }

        /* ===== Newsletter Popup ===== */
        #nl-popup-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.55);
            z-index: 99999;
            align-items: center;
            justify-content: center;
        }
        #nl-popup-overlay.show { display: flex; }
        #nl-popup {
            background: #fff;
            border-radius: 20px;
            padding: 40px 36px 32px;
            max-width: 480px;
            width: 92%;
            position: relative;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,.18);
            animation: nlPop .35s ease;
        }
        @keyframes nlPop {
            from { transform: scale(.85); opacity: 0; }
            to   { transform: scale(1);   opacity: 1; }
        }
        #nl-popup .nl-icon {
            width: 64px; height: 64px;
            background: color-mix(in srgb, {{ $p }} 15%, #fff);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 18px;
        }
        #nl-popup h3 { font-size: 20px; font-weight: 700; margin-bottom: 10px; color: {{ $td }}; }
        #nl-popup p  { font-size: 14px; color: {{ $tm }}; line-height: 1.8; margin-bottom: 22px; }
        #nl-popup .nl-form { display: flex; gap: 10px; flex-wrap: wrap; }
        #nl-popup .nl-form input {
            flex: 1; min-width: 0;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            outline: none;
            transition: border-color .2s;
        }
        #nl-popup .nl-form input:focus { border-color: {{ $p }}; }
        #nl-popup .nl-form button {
            background: {{ $p }};
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 22px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity .2s;
        }
        #nl-popup .nl-form button:hover { opacity: .88; }
        #nl-popup-close {
            position: absolute;
            top: 14px; {{ $locale === 'ar' ? 'left' : 'right' }}: 16px;
            background: none; border: none;
            font-size: 22px; color: #aaa;
            cursor: pointer; line-height: 1;
        }
        #nl-popup-close:hover { color: #555; }
        #nl-popup .nl-skip {
            display: block;
            margin-top: 14px;
            font-size: 12px;
            color: #bbb;
            cursor: pointer;
            text-decoration: underline;
        }
        #nl-popup .nl-skip:hover { color: #888; }
    </style>

    @stack('styles')
</head>
<body>
    @include('partials.navbar')
    <main>@yield('content')</main>
    @include('partials.footer')

    {{-- ===== Newsletter Popup ===== --}}
    <div id="nl-popup-overlay">
        <div id="nl-popup" role="dialog" aria-modal="true">
            <button id="nl-popup-close" aria-label="close">&times;</button>
            <div class="nl-icon">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24">
                    <path d="M2 6.5A2.5 2.5 0 0 1 4.5 4h15A2.5 2.5 0 0 1 22 6.5v11A2.5 2.5 0 0 1 19.5 20h-15A2.5 2.5 0 0 1 2 17.5v-11Z" stroke="{{ $p }}" stroke-width="1.6"/>
                    <path d="m2 7 10 7 10-7" stroke="{{ $p }}" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
            </div>
            <h3>{{ $locale === 'ar' ? 'اشترك في نشرتنا البريدية' : 'Subscribe to Our Newsletter' }}</h3>
            <p>{{ $locale === 'ar'
                ? 'كن أول من يعلم بمشاريعنا الجديدة، قصص المستفيدين، وتأثير تبرعاتك. لا بريد مزعج.. فقط أثر يصل إلى قلبك.'
                : 'Be the first to know about our new projects, beneficiary stories, and the impact of your donations. No spam — just impact.' }}</p>
            <form class="nl-form" id="nl-popup-form" action="#" method="POST">
                @csrf
                <input type="email" name="email" required
                    placeholder="{{ $locale === 'ar' ? 'بريدك الإلكتروني' : 'Your email address' }}">
                <button type="submit">{{ $locale === 'ar' ? 'اشترك الآن' : 'Subscribe' }}</button>
            </form>
            <span class="nl-skip" id="nl-popup-skip">
                {{ $locale === 'ar' ? 'ليس الآن، شكرًا' : 'Not now, thanks' }}
            </span>
        </div>
    </div>

    <script src="https://roaya-ansany.com/website/libs/slimselect/slimselect.js"></script>
    <script src="https://roaya-ansany.com/website/libs/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="https://roaya-ansany.com/website/js/main.js" defer></script>
    <script>
    window.addEventListener("scroll",function(){const n=document.querySelector(".main-navbar");if(n){if(window.scrollY>30)n.classList.add("scrolled");else n.classList.remove("scrolled");}});
    const scrollBtn=document.getElementById("scrollTopBtn");if(scrollBtn){window.addEventListener("scroll",function(){scrollBtn.style.display=window.scrollY>250?"flex":"none";});scrollBtn.addEventListener("click",function(){window.scrollTo({top:0,behavior:"smooth"});});}
    document.addEventListener('click',function(e){const btn=e.target.closest('.btn-donate');if(!btn)return;e.preventDefault();function findAmount(startEl){let parent=startEl.parentElement;while(parent&&parent!==document.body){const found=parent.querySelector('input[name="amount"],input.form-input');if(found)return found;parent=parent.parentElement;}return null;}const inp=findAmount(btn);const amount=inp?inp.value.trim():'';const base="{{ url(app()->getLocale().'/donate') }}";window.location.href=amount?`${base}?amount=${encodeURIComponent(amount)}`:base;});
    document.addEventListener('input',function(e){if(e.target.name==='amount'){let val=e.target.value.replace(/[^0-9.]/g,'');const parts=val.split('.');if(parts.length>2)val=parts[0]+'.'+parts.slice(1).join('');e.target.value=val;}});

    // ===== Newsletter Popup =====
    (function(){
        const KEY = 'nl_subscribed_v1';
        const overlay = document.getElementById('nl-popup-overlay');
        const closeBtn = document.getElementById('nl-popup-close');
        const skipBtn  = document.getElementById('nl-popup-skip');
        const form     = document.getElementById('nl-popup-form');

        function closePopup() {
            overlay.classList.remove('show');
            localStorage.setItem(KEY, '1');
        }

        // أظهر بعد 2.5 ثانية إذا لم يشترك مسبقاً
        if (!localStorage.getItem(KEY)) {
            setTimeout(function(){ overlay.classList.add('show'); }, 2500);
        }

        closeBtn.addEventListener('click', closePopup);
        skipBtn.addEventListener('click',  closePopup);
        overlay.addEventListener('click', function(e){
            if (e.target === overlay) closePopup();
        });

        form.addEventListener('submit', function(e){
            e.preventDefault();
            // تقدر ترسل fetch request هنا لاحقًا
            closePopup();
        });
    })();
    </script>

    @php $wa = App\Models\Setting::get('whatsapp_number','905398863777'); @endphp
    <a href="https://api.whatsapp.com/send/?phone={{ $wa }}&text={{ urlencode('مرحباً بك') }}" target="_blank" class="whatsapp-float" aria-label="WhatsApp">
        <svg fill="#fff" width="30px" height="30px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M26.576 5.363c-2.69-2.69-6.406-4.354-10.511-4.354-8.209 0-14.865 6.655-14.865 14.865 0 2.732 0.737 5.291 2.022 7.491l-0.038-0.070-2.109 7.702 7.879-2.067c2.051 1.139 4.498 1.809 7.102 1.809h0.006c8.209-0.003 14.862-6.659 14.862-14.868 0-4.103-1.662-7.817-4.349-10.507l0 0zM16.062 28.228h-0.005c-2-319 0-4.489-0.64-6.342-1.753l0.056 0.031-0.451-0.267-4.675 1.227 1.247-4.559-0.294-0.467c-1.185-1.862-1.889-4.131-1.889-6.565 0-6.822 5.531-12.353 12.353-12.353s12.353 5.531 12.353 12.353c0 6.822-5.53 12.353-12.353 12.353h-0z"/></svg>
    </a>
    <button id="scrollTopBtn" class="scroll-top-float" style="display:none;">&#8593;</button>
    @stack('scripts')
</body>
</html>
