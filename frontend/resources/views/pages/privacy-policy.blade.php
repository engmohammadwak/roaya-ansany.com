@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'سياسة الخصوصية':'Privacy Policy') . ' | مؤسسة رؤيا الإنسانية')

@section('content')

<section class="page-hero-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url($locale) }}">{{ $locale==='ar'?'الرئيسية':'Home' }}</a></li>
                <li class="breadcrumb-item active">{{ $locale==='ar'?'سياسة الخصوصية':'Privacy Policy' }}</li>
            </ol>
        </nav>
        <h1 class="section-title">{{ $locale==='ar'?'سياسة الخصوصية':'Privacy Policy' }}</h1>
        <p class="muted-color mt-2">{{ $locale==='ar'?'آخر تحديث: يناير 2025':'Last updated: January 2025' }}</p>
    </div>
</section>

<section class="main-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="legal-content">

                    @php
                    $sections = [
                        [
                            'title' => $locale==='ar'?'1. المقدمة':'1. Introduction',
                            'body'  => $locale==='ar'
                                ? 'نحن في مؤسسة رؤيا الإنسانية نلتزم بحماية خصوصيتك وأمان بياناتك الشخصية. توضح هذه السياسة كيفية جمع معلوماتك واستخدامها وحمايتها عند استخدام موقعنا الإلكتروني وخدماتنا.'
                                : 'At Roaya Insanya Foundation, we are committed to protecting your privacy and the security of your personal data. This policy explains how we collect, use, and protect your information when you use our website and services.',
                        ],
                        [
                            'title' => $locale==='ar'?'2. المعلومات التي نجمعها':'2. Information We Collect',
                            'body'  => $locale==='ar'
                                ? "نقوم بجمع المعلومات التالية:\n• الاسم الكامل وبيانات الاتصال (البريد الإلكتروني، رقم الهاتف)\n• بيانات الدفع المشفرة عند إجراء التبرعات\n• معلومات التصفح مثل عنوان IP وملفات تعريف الارتباط (Cookies)\n• أي معلومات تقدمها طوعًا عند التواصل معنا"
                                : "We collect the following information:\n• Full name and contact details (email, phone number)\n• Encrypted payment data when making donations\n• Browsing information such as IP address and cookies\n• Any information you voluntarily provide when contacting us",
                        ],
                        [
                            'title' => $locale==='ar'?'3. كيف نستخدم معلوماتك':'3. How We Use Your Information',
                            'body'  => $locale==='ar'
                                ? "نستخدم معلوماتك للأغراض التالية:\n• معالجة التبرعات وإرسال تأكيدات الاستلام\n• التواصل معك بشأن المشاريع والتحديثات\n• تحسين خدماتنا وتجربة المستخدم على الموقع\n• الامتثال للمتطلبات القانونية والتنظيمية"
                                : "We use your information for the following purposes:\n• Processing donations and sending receipt confirmations\n• Communicating with you about projects and updates\n• Improving our services and user experience on the website\n• Complying with legal and regulatory requirements",
                        ],
                        [
                            'title' => $locale==='ar'?'4. حماية المعلومات':'4. Information Protection',
                            'body'  => $locale==='ar'
                                ? 'نستخدم تقنيات تشفير SSL/TLS لحماية بياناتك أثناء الإرسال. لا نشارك معلوماتك الشخصية مع أطراف ثالثة إلا عند الضرورة لتنفيذ الخدمات أو وفق متطلبات القانون.'
                                : 'We use SSL/TLS encryption technologies to protect your data during transmission. We do not share your personal information with third parties except when necessary to perform services or as required by law.',
                        ],
                        [
                            'title' => $locale==='ar'?'5. ملفات تعريف الارتباط (Cookies)':'5. Cookies',
                            'body'  => $locale==='ar'
                                ? 'يستخدم موقعنا ملفات تعريف الارتباط لتحسين تجربتك. يمكنك تعطيل ملفات Cookies من إعدادات متصفحك، علمًا بأن ذلك قد يؤثر على بعض وظائف الموقع.'
                                : 'Our website uses cookies to improve your experience. You can disable cookies from your browser settings, although this may affect some website functionalities.',
                        ],
                        [
                            'title' => $locale==='ar'?'6. حقوقك':'6. Your Rights',
                            'body'  => $locale==='ar'
                                ? "يحق لك:\n• الاطلاع على البيانات الشخصية التي لدينا عنك\n• طلب تصحيح أو حذف بياناتك\n• سحب موافقتك على استخدام بياناتك في أي وقت\n• تقديم شكوى إلى الجهات المختصة"
                                : "You have the right to:\n• Access the personal data we hold about you\n• Request correction or deletion of your data\n• Withdraw your consent to the use of your data at any time\n• Lodge a complaint with the relevant authorities",
                        ],
                        [
                            'title' => $locale==='ar'?'7. التواصل معنا':'7. Contact Us',
                            'body'  => $locale==='ar'
                                ? 'إذا كان لديك أي استفسار حول سياسة الخصوصية، يمكنك التواصل معنا عبر البريد الإلكتروني: info@roaya-ansany.com أو من خلال صفحة اتصل بنا.'
                                : 'If you have any questions about the privacy policy, you can contact us via email: info@roaya-ansany.com or through the Contact Us page.',
                        ],
                    ];
                    @endphp

                    @foreach($sections as $sec)
                    <div class="legal-section mb-4">
                        <h4 class="legal-title">{{ $sec['title'] }}</h4>
                        <div class="legal-body">{!! nl2br(e($sec['body'])) !!}</div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.page-hero-section { background:linear-gradient(135deg,#f8fdf4,#eef7e6); padding:60px 0 40px; }
.page-hero-section .breadcrumb-item a { color:#5a9e2f; text-decoration:none; }
.legal-content { background:white; border-radius:20px; padding:40px; box-shadow:0 4px 20px rgba(0,0,0,0.06); border:1px solid #e8f4d9; }
.legal-section { border-bottom:1px solid #f0f7e6; padding-bottom:24px; }
.legal-section:last-child { border-bottom:none; }
.legal-title { font-size:17px; font-weight:700; color:#5a9e2f; margin-bottom:12px; }
.legal-body { color:#555; line-height:1.9; font-size:15px; }
</style>
@endpush
@endsection
