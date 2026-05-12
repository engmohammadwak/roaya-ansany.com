@php
    $locale      = app()->getLocale();
    $otherLocale = $locale === 'ar' ? 'en' : 'ar';
    $siteLogo    = App\Models\Setting::get('site_logo');
    $siteName    = App\Models\Setting::get('site_name', 'رؤيا');

    // روابط النافبار — on/off من الإعدادات
    $navLinks = [
        'home'    => ['ar' => 'الرئيسية',       'en' => 'Home',           'path' => $locale],
        'about'   => ['ar' => 'من نحن',           'en' => 'About Us',       'path' => $locale.'/about'],
        'campaigns'=>['ar' => 'الحملات',          'en' => 'Campaigns',      'path' => $locale.'/campaigns'],
        'blogs'   => ['ar' => 'المدونة',          'en' => 'Blog',           'path' => $locale.'/blogs'],
        'contact' => ['ar' => 'تواصل معنا',       'en' => 'Contact Us',     'path' => $locale.'/contact'],
        'privacy' => ['ar' => 'سياسة الخصوصية',  'en' => 'Privacy Policy', 'path' => $locale.'/privacy-policy'],
    ];
@endphp

<header>
<nav id="main-navbar"
     class="navbar navbar-expand-lg py-2 fixed-top main-navbar"
     aria-label="Main Navigation">
    <div class="container position-relative">

        {{-- اللوجو --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ url($locale) }}">
            @if($siteLogo)
                <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}" class="me-2" style="max-height:50px;">
            @else
                <img src="https://roaya-ansany.com/website/images/logo.svg" alt="{{ $siteName }}" class="me-2">
            @endif
        </a>

        <div class="d-flex align-items-center">
            <div class="language-switcher mobile me-3">
                <a href="{{ url($otherLocale) }}">{{ $locale === 'ar' ? 'English' : 'العربية' }}</a>
            </div>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav links-holder mx-auto mb-2 mb-lg-0">
                @foreach($navLinks as $key => $link)
                    @if(App\Models\Setting::get('nav_show_'.$key, '1') === '1')
                    <li class="nav-item me-4">
                        <a class="nav-link {{ request()->is($link['path']) || request()->is($link['path'].'/*') ? 'active' : '' }}"
                           href="{{ url($link['path']) }}">{{ $link[$locale] }}</a>
                    </li>
                    @endif
                @endforeach
            </ul>
            <div class="d-flex justify-content-center align-items-center">
                <div class="language-switcher me-3">
                    <a href="{{ url($otherLocale) }}" class="lang-value">{{ $locale === 'ar' ? 'English' : 'العربية' }}</a>
                </div>
                <a href="{{ url($locale.'/donate') }}" class="btn-donate">{{ $locale === 'ar' ? 'تبرع' : 'Donate' }}</a>
            </div>
        </div>

    </div>
</nav>
</header>

{{-- sticky-only: النافبار تظهر بس لما يسكرول للأسفل --}}
@if(App\Models\Setting::get('navbar_sticky_only', '0') === '1')
<style>
    #main-navbar {
        transform: translateY(-100%);
        transition: transform 0.35s ease, background 0.3s ease, box-shadow 0.3s ease;
        background: transparent !important;
        box-shadow: none !important;
    }
    #main-navbar.is-sticky {
        transform: translateY(0);
        background: var(--color-bg-body, #fff) !important;
        box-shadow: 0 2px 16px rgba(0,0,0,0.10) !important;
    }
</style>
<script>
(function(){
    var nav = document.getElementById('main-navbar');
    window.addEventListener('scroll', function(){
        if(window.scrollY > 60){
            nav.classList.add('is-sticky');
        } else {
            nav.classList.remove('is-sticky');
        }
    }, { passive: true });
})();
</script>
@endif
