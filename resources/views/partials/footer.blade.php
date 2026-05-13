@php
    $locale      = app()->getLocale();
    $siteLogoRaw  = App\Models\Setting::get('site_logo');
    $siteLogo     = $siteLogoRaw
        ? (str_starts_with($siteLogoRaw, 'http') ? $siteLogoRaw : asset('storage/' . $siteLogoRaw))
        : null;
    $siteName     = App\Models\Setting::get('site_name', 'رؤيا');
    $footerDescAr = App\Models\Setting::get('footer_description_ar', '');
    $footerDescEn = App\Models\Setting::get('footer_description_en', '');
    $copyrightAr  = App\Models\Setting::get('footer_copyright_ar', 'جميع الحقوق محفوظة © مؤسسة رؤيا الإنسانية ' . date('Y'));
    $copyrightEn  = App\Models\Setting::get('footer_copyright_en', 'All Rights Reserved © Roaya Insanya ' . date('Y'));

    // social links
    $socialFb  = App\Models\Setting::get('social_facebook',  '');
    $socialIg  = App\Models\Setting::get('social_instagram', '');
    $socialTw  = App\Models\Setting::get('social_twitter',   '');
    $socialWa  = App\Models\Setting::get('social_whatsapp',  '');

    $phones = array_filter([
        App\Models\Setting::get('contact_phone',   ''),
        App\Models\Setting::get('contact_phone_2', ''),
        App\Models\Setting::get('contact_phone_3', ''),
    ]);
    $emails = array_filter([
        App\Models\Setting::get('contact_email',   ''),
        App\Models\Setting::get('contact_email_2', ''),
        App\Models\Setting::get('contact_email_3', ''),
    ]);

    $whatsapps = [];
    $waNums  = [
        App\Models\Setting::get('whatsapp_number',   ''),
        App\Models\Setting::get('whatsapp_number_2', ''),
        App\Models\Setting::get('whatsapp_number_3', ''),
    ];
    $waTexts = [
        App\Models\Setting::get('whatsapp_text_1', ''),
        App\Models\Setting::get('whatsapp_text_2', ''),
        App\Models\Setting::get('whatsapp_text_3', ''),
    ];
    foreach ($waNums as $i => $num) {
        if (trim($num)) {
            $whatsapps[] = ['number' => trim($num), 'text' => trim($waTexts[$i])];
        }
    }

    $blogActive = App\Models\BlogPage::isEnabled();
@endphp
<footer class="footer mt-5 border-top pt-3">
    <div class="container overflow-hidden">
        <div class="row gy-4">
            <div class="col-md-4">
                <a href="{{ url($locale) }}">
                    @if($siteLogo)
                        <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="footer-logo mb-2" style="max-height:80px;">
                    @else
                        <img width="134" height="113" src="https://roaya-ansany.com/website/images/logo.svg" alt="{{ $siteName }}" class="footer-logo mb-2">
                    @endif
                </a>
                @php $footerDesc = $locale === 'ar' ? $footerDescAr : $footerDescEn; @endphp
                @if($footerDesc)
                <p class="footer-about muted-color">{{ $footerDesc }}</p>
                @endif

                {{-- Social Icons - from dashboard --}}
                @if($socialFb || $socialIg || $socialTw || $socialWa)
                <div class="social-icons mt-4">
                    @if($socialFb)
                    <a href="{{ $socialFb }}" target="_blank" rel="noopener">
                        <img width="24" height="24" src="https://roaya-ansany.com/website/images/facebook.svg" alt="facebook">
                    </a>
                    @endif
                    @if($socialIg)
                    <a href="{{ $socialIg }}" target="_blank" rel="noopener">
                        <img width="24" height="24" src="https://roaya-ansany.com/website/images/Instagram.svg" alt="Instagram">
                    </a>
                    @endif
                    @if($socialTw)
                    <a href="{{ $socialTw }}" target="_blank" rel="noopener">
                        <img width="24" height="24" src="https://roaya-ansany.com/website/images/xtwitter.png" alt="X">
                    </a>
                    @endif
                    @if($socialWa)
                    <a href="{{ $socialWa }}" target="_blank" rel="noopener">
                        <img width="24" height="24" src="https://roaya-ansany.com/website/images/whatsapp.svg"
                            onerror="this.src='https://roaya-ansany.com/website/images/phone.svg'" alt="WhatsApp">
                    </a>
                    @endif
                </div>
                @endif
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-6 col-md-4 mt-5">
                        <h5>{{ $locale === 'ar' ? 'روابط سريعة' : 'Quick Links' }}</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ url($locale) }}">{{ $locale === 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                            <li><a href="{{ url($locale.'/about') }}">{{ $locale === 'ar' ? 'من نحن' : 'About Us' }}</a></li>
                            @if($blogActive)
                            <li><a href="{{ url($locale.'/blogs') }}">{{ $locale === 'ar' ? 'المدونة' : 'Blog' }}</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-6 col-md-4 mt-5">
                        <h5>{{ $locale === 'ar' ? 'المصادر' : 'Resources' }}</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ url($locale.'/contact') }}">{{ $locale === 'ar' ? 'تواصل معنا' : 'Contact Us' }}</a></li>
                            <li><a href="{{ url($locale.'/privacy-policy') }}">{{ $locale === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy' }}</a></li>
                            <li><a href="{{ url($locale.'/terms-and-conditions') }}">{{ $locale === 'ar' ? 'القواعد والأحكام' : 'Terms & Conditions' }}</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-4 mt-5">
                        <h5>{{ $locale === 'ar' ? 'تواصل معنا' : 'Contact Us' }}</h5>

                        @foreach($phones as $phone)
                        <p class="mb-2">
                            <img class="me-2" src="https://roaya-ansany.com/website/images/phone.svg" alt="phone">
                            <span class="muted-color" dir="ltr">
                                <a class="link-offset-2 link-underline link-underline-opacity-0 link-secondary" href="tel:{{ $phone }}">{{ $phone }}</a>
                            </span>
                        </p>
                        @endforeach

                        @foreach($emails as $email)
                        <p class="mb-2">
                            <img class="me-2" src="https://roaya-ansany.com/website/images/message.svg" alt="message">
                            <span class="muted-color">
                                <a class="link-offset-2 link-underline link-underline-opacity-0 link-secondary" href="mailto:{{ $email }}">{{ $email }}</a>
                            </span>
                        </p>
                        @endforeach

                        @foreach($whatsapps as $wa)
                        @php
                            $waUrl = 'https://wa.me/' . $wa['number'];
                            if ($wa['text']) { $waUrl .= '?text=' . rawurlencode($wa['text']); }
                        @endphp
                        <p class="mb-2">
                            <img class="me-2" src="https://roaya-ansany.com/website/images/whatsapp.svg"
                                onerror="this.src='https://roaya-ansany.com/website/images/phone.svg'" alt="whatsapp">
                            <span class="muted-color" dir="ltr">
                                <a class="link-offset-2 link-underline link-underline-opacity-0 link-secondary"
                                    href="{{ $waUrl }}" target="_blank">+{{ $wa['number'] }}</a>
                            </span>
                        </p>
                        @endforeach

                        @if(empty($phones) && empty($emails) && empty($whatsapps))
                        <p class="text-muted small">{{ $locale === 'ar' ? 'لا توجد معلومات تواصل' : 'No contact info available' }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom mt-4 py-3 border-top">
        <div class="container">
            <p class="m-0 text-center text-lg-start muted-color">
                {{ $locale === 'ar' ? $copyrightAr : $copyrightEn }}
            </p>
        </div>
    </div>
</footer>
