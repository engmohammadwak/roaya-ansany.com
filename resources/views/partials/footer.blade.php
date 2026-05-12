@php $locale = app()->getLocale(); @endphp
<footer style="background:#1a1a2e; color:#fff; padding:40px 20px; margin-top:60px;">
    <div style="max-width:1200px; margin:0 auto; display:flex; flex-wrap:wrap; gap:40px; justify-content:space-between;">

        {{-- Logo & Description --}}
        <div style="max-width:300px;">
            <img src="{{ asset('assets/logoramadan2.png') }}" alt="logo" style="height:50px; margin-bottom:16px;">
            <p style="color:#aaa; font-size:14px; line-height:1.7;">{{ __('footer.description') }}</p>
        </div>

        {{-- Links --}}
        <div>
            <h4 style="margin-bottom:16px; font-size:16px;">{{ __('footer.links') }}</h4>
            <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px;">
                <li><a href="{{ route('home', $locale) }}" style="color:#aaa; text-decoration:none;">{{ __('nav.home') }}</a></li>
                <li><a href="{{ route('about', $locale) }}" style="color:#aaa; text-decoration:none;">{{ __('nav.about') }}</a></li>
                <li><a href="{{ route('campaigns', $locale) }}" style="color:#aaa; text-decoration:none;">{{ __('nav.campaigns') }}</a></li>
                <li><a href="{{ route('blogs', $locale) }}" style="color:#aaa; text-decoration:none;">{{ __('nav.blogs') }}</a></li>
                <li><a href="{{ route('contact', $locale) }}" style="color:#aaa; text-decoration:none;">{{ __('nav.contact') }}</a></li>
            </ul>
        </div>

        {{-- Legal --}}
        <div>
            <h4 style="margin-bottom:16px; font-size:16px;">{{ __('footer.legal') }}</h4>
            <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px;">
                <li><a href="{{ route('privacy', $locale) }}" style="color:#aaa; text-decoration:none;">{{ __('footer.privacy') }}</a></li>
                <li><a href="{{ route('terms', $locale) }}" style="color:#aaa; text-decoration:none;">{{ __('footer.terms') }}</a></li>
            </ul>
        </div>
    </div>

    <div style="text-align:center; margin-top:40px; padding-top:20px; border-top:1px solid #333; color:#666; font-size:13px;">
        &copy; {{ date('Y') }} {{ __('app.name') }} — {{ __('footer.rights') }}
    </div>
</footer>
