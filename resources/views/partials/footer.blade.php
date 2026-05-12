{{-- Footer - استبدل بمحتوى الـ footer من ملفات الـ HTML القديمة --}}
<footer>
    <p>{{ Setting::get('site_name_' . app()->getLocale()) }} &copy; {{ date('Y') }}</p>

    <div>
        @if(Setting::get('facebook_url'))
            <a href="{{ Setting::get('facebook_url') }}" target="_blank">Facebook</a>
        @endif
        @if(Setting::get('twitter_url'))
            <a href="{{ Setting::get('twitter_url') }}" target="_blank">Twitter</a>
        @endif
        @if(Setting::get('instagram_url'))
            <a href="{{ Setting::get('instagram_url') }}" target="_blank">Instagram</a>
        @endif
        @if(Setting::get('youtube_url'))
            <a href="{{ Setting::get('youtube_url') }}" target="_blank">YouTube</a>
        @endif
    </div>

    <div>
        <a href="{{ route('privacy', app()->getLocale()) }}">{{ __('nav.privacy') }}</a>
        <a href="{{ route('terms', app()->getLocale()) }}">{{ __('nav.terms') }}</a>
    </div>
</footer>
