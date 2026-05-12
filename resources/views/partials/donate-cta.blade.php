@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';
    $home   = isset($home) ? $home : \App\Models\HomeSetting::first();
@endphp
<section class="main-section">
    <div class="container">
        <div class="donate overflow-hidden">

            <div class="content">
                <h2 class="main-title text-white mb-4">
                    {{ $isAr
                        ? ($home?->donate_title_ar ?? 'تبرّع الآن — أنقذ حياة')
                        : ($home?->donate_title_en ?? 'Donate Now — Save a Life') }}
                </h2>

                <p>
                    {{ $isAr
                        ? ($home?->donate_desc_ar ?? 'تبرّع الآن وأنقذ حياة. في مكان ما، هناك شخص ينتظر يد العون لتغيير واقعه وإعادة الأمل إلى حياته.')
                        : ($home?->donate_desc_en ?? 'Donate now and save a life. Somewhere, someone is waiting for your help to change their reality.') }}
                </p>

                <div class="mt-4 holder">
                    <input type="text" name="amount" id="donateCta" class="form-input"
                           placeholder="{{ $isAr ? 'ادخل المبلغ' : 'Enter amount' }}">
                    <button type="button" class="btn-donate"
                        onclick="window.location='{{ url($locale.'/donate') }}?amount='+document.getElementById('donateCta').value">
                        {{ $isAr ? 'تبرع' : 'Donate' }}
                    </button>
                </div>
            </div>

            <img src="{{ asset('website/images/donate-child.svg') }}" class="d-none d-lg-block" alt="donate image">

        </div>
    </div>
</section>
