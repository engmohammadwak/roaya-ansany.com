@php $locale = app()->getLocale(); $otherLocale = $locale === 'ar' ? 'en' : 'ar'; @endphp
<header>
<nav class="navbar navbar-expand-lg py-2 fixed-top main-navbar" aria-label="Main Navigation">
    <div class="container position-relative">
        <a class="navbar-brand d-flex align-items-center" href="{{ url($locale) }}">
            <img src="https://roaya-ansany.com/website/images/logo.svg" alt="روايا انساني" class="me-2">
        </a>

        <div class="d-flex align-items-center">
            <div class="language-switcher mobile me-3">
                <a href="{{ url($otherLocale) }}">{{ $locale === 'ar' ? 'English' : 'العربية' }}</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav links-holder mx-auto mb-2 mb-lg-0">
                <li class="nav-item me-4">
                    <a class="nav-link {{ request()->is($locale) || request()->is($locale.'/') ? 'active' : '' }}"
                       href="{{ url($locale) }}">{{ $locale === 'ar' ? 'الرئيسية' : 'Home' }}</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link {{ request()->is($locale.'/about') ? 'active' : '' }}"
                       href="{{ url($locale.'/about') }}">{{ $locale === 'ar' ? 'من نحن' : 'About Us' }}</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link {{ request()->is($locale.'/campaigns*') ? 'active' : '' }}"
                       href="{{ url($locale.'/campaigns') }}">{{ $locale === 'ar' ? 'الحملات' : 'Campaigns' }}</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link {{ request()->is($locale.'/blogs*') ? 'active' : '' }}"
                       href="{{ url($locale.'/blogs') }}">{{ $locale === 'ar' ? 'المدونة' : 'Blog' }}</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link {{ request()->is($locale.'/contact') ? 'active' : '' }}"
                       href="{{ url($locale.'/contact') }}">{{ $locale === 'ar' ? 'تواصل معنا' : 'Contact Us' }}</a>
                </li>
                <li class="nav-item me-4">
                    <a class="nav-link" href="{{ url($locale.'/privacy-policy') }}">{{ $locale === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}</a>
                </li>
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
