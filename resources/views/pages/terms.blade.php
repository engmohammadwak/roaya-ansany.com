@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'شروط الاستخدام':'Terms of Use') . ' | مؤسسة رؤيا الإنسانية')

@section('content')

<section class="page-hero-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url($locale) }}">{{ $locale==='ar'?'الرئيسية':'Home' }}</a></li>
                <li class="breadcrumb-item active">{{ $locale==='ar'?'شروط الاستخدام':'Terms of Use' }}</li>
            </ol>
        </nav>
        <h1 class="section-title">{{ $locale==='ar'?'شروط الاستخدام':'Terms of Use' }}</h1>
        <p class="muted-color mt-2">{{ $locale==='ar'?'يُرجى قراءة هذه الشروط بعناية قبل استخدام الموقع.':'Please read these terms carefully before using the website.' }}</p>
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
                            'title' => $locale==='ar'?'1. القبول بالشروط':'1. Acceptance of Terms',
                            'body'  => $locale==='ar'
                                ? 'باستخدامك لموقع مؤسسة رؤيا الإنسانية، فإنك توافق على الالتزام بهذه الشروط والأحكام. إذا كنت لا توافق على هذه الشروط، يرجى عدم استخدام الموقع.'
                                : 'By using the Roaya Insanya Foundation website, you agree to comply with these terms and conditions. If you do not agree to these terms, please do not use the website.',
                        ],
                        [
                            'title' => $locale==='ar'?'2. استخدام الموقع':'2. Use of Website',
                            'body'  => $locale==='ar'
                                ? "يجب استخدام الموقع للأغراض المشروعة فقط. يُحظر:\n• نشر أي محتوى مسيء أو مخالف للقانون\n• محاولة اختراق أو إتلاف أنظمة الموقع\n• انتهاك حقوق الملكية الفكرية\n• استخدام الموقع لأغراض احتيالية"
                                : "The website must be used for lawful purposes only. The following are prohibited:\n• Publishing any offensive or illegal content\n• Attempting to breach or damage website systems\n• Violating intellectual property rights\n• Using the website for fraudulent purposes",
                        ],
                        [
                            'title' => $locale==='ar'?'3. التبرعات والمدفوعات':'3. Donations & Payments',
                            'body'  => $locale==='ar'
                                ? 'جميع التبرعات نهائية وغير قابلة للاسترداد إلا في حالات استثنائية وفق السياسات المعمول بها. نحن نستخدم بوابات دفع آمنة ومعتمدة لمعالجة جميع المعاملات المالية.'
                                : 'All donations are final and non-refundable except in exceptional cases according to applicable policies. We use secure and certified payment gateways to process all financial transactions.',
                        ],
                        [
                            'title' => $locale==='ar'?'4. الملكية الفكرية':'4. Intellectual Property',
                            'body'  => $locale==='ar'
                                ? 'جميع المحتويات المنشورة على الموقع من نصوص وصور وشعارات وتصاميم هي ملك حصري لمؤسسة رؤيا الإنسانية ومحمية بموجب قوانين حقوق الملكية الفكرية. لا يجوز نسخها أو إعادة نشرها بدون إذن مسبق.'
                                : 'All content published on the website including texts, images, logos, and designs are the exclusive property of Roaya Insanya Foundation and are protected under intellectual property laws. They may not be copied or republished without prior permission.',
                        ],
                        [
                            'title' => $locale==='ar'?'5. إخلاء المسؤولية':'5. Disclaimer',
                            'body'  => $locale==='ar'
                                ? 'يُقدَّم الموقع "كما هو" دون أي ضمانات صريحة أو ضمنية. لا تتحمل المؤسسة المسؤولية عن أي أضرار مباشرة أو غير مباشرة ناتجة عن استخدام الموقع.'
                                : 'The website is provided "as is" without any express or implied warranties. The Foundation is not liable for any direct or indirect damages resulting from the use of the website.',
                        ],
                        [
                            'title' => $locale==='ar'?'6. التعديلات على الشروط':'6. Modifications to Terms',
                            'body'  => $locale==='ar'
                                ? 'تحتفظ المؤسسة بالحق في تعديل هذه الشروط في أي وقت. سيتم إخطارك بأي تغييرات جوهرية عبر البريد الإلكتروني أو من خلال إشعار بارز على الموقع.'
                                : 'The Foundation reserves the right to modify these terms at any time. You will be notified of any material changes via email or through a prominent notice on the website.',
                        ],
                        [
                            'title' => $locale==='ar'?'7. القانون المطبق':'7. Governing Law',
                            'body'  => $locale==='ar'
                                ? 'تخضع هذه الشروط وتُفسَّر وفقًا لقوانين جمهورية تركيا. أي نزاع ينشأ عن هذه الشروط يخضع للاختصاص القضائي للمحاكم التركية.'
                                : 'These terms are governed by and construed in accordance with the laws of the Republic of Turkey. Any dispute arising from these terms is subject to the jurisdiction of Turkish courts.',
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
