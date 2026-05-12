@php $locale = app()->getLocale(); @endphp
<header class="MuiPaper-root MuiPaper-elevation MuiPaper-elevation0 MuiAppBar-root MuiAppBar-colorTransparent MuiAppBar-positionStatic muirtl-1bey8oq" style="--Paper-shadow: none">
    <div class="MuiBox-root muirtl-p3p2le">
        <div class="MuiToolbar-root MuiToolbar-regular muirtl-ouw5bya">
            {{-- Logo --}}
            <a href="{{ route('home', $locale) }}">
                <img class="MuiBox-root muirtl-1dzeblt" alt="logo" src="{{ asset('assets/logoramadan2.png') }}">
            </a>

            {{-- Desktop Nav --}}
            <div class="MuiBox-root muirtl-1woqn6j" style="display:flex; align-items:center; gap:8px;">
                <a class="MuiButtonBase-root MuiButton-root MuiButton-text MuiButton-textInherit muirtl-q6qwjj"
                   href="{{ route('campaigns', $locale) }}">{{ __('nav.campaigns') }}</a>
                <a class="MuiButtonBase-root MuiButton-root MuiButton-text MuiButton-textInherit muirtl-q6qwjj"
                   href="{{ route('home', $locale) . '#programs' }}">{{ __('nav.programs') }}</a>
                <a class="MuiButtonBase-root MuiButton-root MuiButton-text MuiButton-textInherit muirtl-q6qwjj"
                   href="{{ route('blogs', $locale) }}">{{ __('nav.blogs') }}</a>
                <a class="MuiButtonBase-root MuiButton-root MuiButton-text MuiButton-textInherit muirtl-q6qwjj"
                   href="{{ route('about', $locale) }}">{{ __('nav.about') }}</a>
                <a class="MuiButtonBase-root MuiButton-root MuiButton-text MuiButton-textInherit muirtl-q6qwjj"
                   href="{{ route('contact', $locale) }}">{{ __('nav.contact') }}</a>

                {{-- Language Switch --}}
                <a href="{{ url(($locale === 'ar' ? 'en' : 'ar') . '/' . request()->path() ) }}"
                   style="font-size:13px; margin: 0 8px;">
                   {{ $locale === 'ar' ? 'English' : 'العربية' }}
                </a>

                {{-- Donate Button --}}
                <a class="MuiButtonBase-root MuiButton-root MuiButton-contained MuiButton-containedInherit MuiButton-disableElevation muirtl-1d2fs8q"
                   href="{{ route('donate', $locale) }}">
                    {{ __('nav.donate') }}
                </a>
            </div>

            {{-- Mobile Hamburger --}}
            <button class="MuiButtonBase-root MuiIconButton-root MuiIconButton-colorInherit MuiIconButton-sizeLarge muirtl-x15t5c"
                    id="mobile-menu-btn" type="button" aria-label="menu" style="display:none">
                <svg class="MuiSvgIcon-root muirtl-q7mezt" focusable="false" aria-hidden="true" viewBox="0 0 24 24">
                    <path d="M3 18h18v-2H3zm0-5h18v-2H3zm0-7v2h18V6z"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Drawer --}}
    <div id="mobile-menu" style="display:none; flex-direction:column; padding:16px; background:#fff;">
        <a href="{{ route('campaigns', $locale) }}">{{ __('nav.campaigns') }}</a>
        <a href="{{ route('blogs', $locale) }}">{{ __('nav.blogs') }}</a>
        <a href="{{ route('about', $locale) }}">{{ __('nav.about') }}</a>
        <a href="{{ route('contact', $locale) }}">{{ __('nav.contact') }}</a>
        <a href="{{ route('donate', $locale) }}">{{ __('nav.donate') }}</a>
    </div>
</header>

@push('scripts')
<script>
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (btn) {
        btn.addEventListener('click', () => {
            menu.style.display = menu.style.display === 'none' ? 'flex' : 'none';
        });
    }

    // Show hamburger on mobile
    if (window.innerWidth < 900) {
        btn && (btn.style.display = 'flex');
    }
</script>
@endpush
