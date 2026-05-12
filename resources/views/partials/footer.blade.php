@php $locale = app()->getLocale(); @endphp
<footer class="footer mt-5 border-top pt-3">
    <div class="container overflow-hidden">
        <div class="row gy-4">
            <div class="col-md-4">
                <a href="{{ url($locale) }}">
                    <img width="134" height="113" src="https://roaya-ansany.com/website/images/logo.svg" alt="رؤيا" class="footer-logo mb-2">
                </a>
                <p class="footer-about muted-color">
                    {{ $locale === 'ar' ? 'رؤيا هي منصة عطاء مخصصة للأشخاص الذين يهتمون بالأثر الحقيقي لعطائهم.' : 'Roaya is a giving platform dedicated to people who care about the real impact of their giving.' }}
                </p>
                <div class="social-icons mt-4">
                    <a href="https://www.facebook.com/profile.php?id=61568018236938" target="_blank">
                        <img width="24" height="24" src="https://roaya-ansany.com/website/images/facebook.svg" alt="facebook">
                    </a>
                    <a href="https://www.instagram.com/roaya.ansany/" target="_blank">
                        <img width="24" height="24" src="https://roaya-ansany.com/website/images/Instagram.svg" alt="Instagram">
                    </a>
                    <a href="https://x.com/RoayaAnsany2025" target="_blank">
                        <img width="24" height="24" src="https://roaya-ansany.com/website/images/xtwitter.png" alt="x">
                    </a>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-6 col-md-4 mt-5">
                        <h5>{{ $locale === 'ar' ? 'روابط سريعة' : 'Quick Links' }}</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ url($locale) }}">{{ $locale === 'ar' ? 'الرئيسية' : 'Home' }}</a></li>
                            <li><a href="{{ url($locale.'/about') }}">{{ $locale === 'ar' ? 'من نحن' : 'About Us' }}</a></li>
                            <li><a href="{{ url($locale.'/blogs') }}">{{ $locale === 'ar' ? 'المدونة' : 'Blog' }}</a></li>
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
                        <p class="mb-3">
                            <img class="me-3" src="https://roaya-ansany.com/website/images/phone.svg" alt="phone">
                            <span class="muted-color" dir="ltr">
                                <a class="link-offset-2 link-underline link-underline-opacity-0 link-secondary" href="tel:+905398863777">+905398863777</a>
                            </span>
                        </p>
                        <p class="mb-3">
                            <img class="me-3" src="https://roaya-ansany.com/website/images/message.svg" alt="message">
                            <span class="muted-color">
                                <a class="link-offset-2 link-underline link-underline-opacity-0 link-secondary" href="mailto:roaya.ansany@gmail.com">roaya.ansany@gmail.com</a>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom mt-4 py-3 border-top">
        <div class="container">
            <p class="m-0 text-center text-lg-start muted-color">
                {{ $locale === 'ar' ? 'جميع الحقوق محفوظة © مؤسسة رؤيا الإنسانية ' . date('Y') : 'All Rights Reserved © Roaya Insanya ' . date('Y') }}
            </p>
        </div>
    </div>
</footer>
