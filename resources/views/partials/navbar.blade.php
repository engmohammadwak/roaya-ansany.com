{{-- Navbar - استبدل بمحتوى الـ navbar من ملفات الـ HTML القديمة --}}
<nav>
    <a href="{{ route('home', app()->getLocale()) }}">
        @if(Setting::get('logo'))
            <img src="{{ asset('storage/' . Setting::get('logo')) }}" alt="{{ Setting::get('site_name_' . app()->getLocale()) }}">
        @else
            {{ Setting::get('site_name_' . app()->getLocale(), 'رؤية إنسانية') }}
        @endif
    </a>

    <ul>
        <li><a href="{{ route('home', app()->getLocale()) }}">{{ __('nav.home') }}</a></li>
        <li><a href="{{ route('about', app()->getLocale()) }}">{{ __('nav.about') }}</a></li>
        <li><a href="{{ route('blogs', app()->getLocale()) }}">{{ __('nav.blogs') }}</a></li>
        <li><a href="{{ route('campaigns', app()->getLocale()) }}">{{ __('nav.campaigns') }}</a></li>
        <li><a href="{{ route('donate', app()->getLocale()) }}">{{ __('nav.donate') }}</a></li>
        <li><a href="{{ route('contact', app()->getLocale()) }}">{{ __('nav.contact') }}</a></li>
    </ul>

    {{-- Language Switcher --}}
    <div>
        @if(app()->getLocale() == 'ar')
            <a href="{{ url('/en') }}">English</a>
        @else
            <a href="{{ url('/ar') }}">العربية</a>
        @endif
    </div>
</nav>
