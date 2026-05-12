@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'الأسئلة الشائعة':'FAQs') . ' | مؤسسة رؤيا الإنسانية')
@section('description', $locale==='ar'?'إجابات على الأسئلة الشائعة حول التبرع ومؤسسة رؤيا الإنسانية.':'Answers to frequently asked questions about donating and Roaya Insanya.')

@section('content')

<section class="page-hero-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url($locale) }}">{{ $locale==='ar'?'الرئيسية':'Home' }}</a></li>
                <li class="breadcrumb-item active">{{ $locale==='ar'?'الأسئلة الشائعة':'FAQs' }}</li>
            </ol>
        </nav>
        <h1 class="section-title">{{ $locale==='ar'?'الأسئلة الشائعة':'Frequently Asked Questions' }}</h1>
        <p class="muted-color mt-2">{{ $locale==='ar'?'إجابات سريعة على أكثر الأسئلة شيوعًا.':'Quick answers to the most common questions.' }}</p>
    </div>
</section>

<section class="main-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                @php
                $faqGroups = [
                    [
                        'group' => $locale==='ar'?'عن المؤسسة':'About the Foundation',
                        'icon'  => 'fa-building',
                        'items' => [
                            [
                                'q' => $locale==='ar'?'ما هي مؤسسة رؤيا الإنسانية؟':'What is Roaya Insanya Foundation?',
                                'a' => $locale==='ar'?'مؤسسة رؤيا الإنسانية هي مؤسسة أهلية غير ربحية تعمل في إطار القوانين التركية، وتُعنى بتقديم خدمات إنسانية وإغاثية تستهدف الفئات الأكثر هشاشة.':'Roaya Insanya is a non-profit organization operating under Turkish law, providing humanitarian and relief services targeting the most vulnerable groups.',
                            ],
                            [
                                'q' => $locale==='ar'?'هل المؤسسة معترف بها رسميًا؟':'Is the foundation officially recognized?',
                                'a' => $locale==='ar'?'نعم، المؤسسة مسجلة وتعمل وفق القوانين المعمول بها، مع التزام كامل بمعايير الشفافية والمحاسبة.':'Yes, the foundation is registered and operates in accordance with applicable laws, with full commitment to transparency and accountability standards.',
                            ],
                        ],
                    ],
                    [
                        'group' => $locale==='ar'?'عن التبرعات':'About Donations',
                        'icon'  => 'fa-hand-holding-heart',
                        'items' => [
                            [
                                'q' => $locale==='ar'?'كيف يمكنني التبرع؟':'How can I donate?',
                                'a' => $locale==='ar'?'يمكنك التبرع مباشرةً من الموقع باختيار المشروع وإدخال المبلغ واستخدام وسائل الدفع المتاحة.':'You can donate directly from the website by selecting a project, entering the amount, and using available payment methods.',
                            ],
                            [
                                'q' => $locale==='ar'?'هل تبرعاتي تصل فعلًا للمستحقين؟':'Do my donations actually reach beneficiaries?',
                                'a' => $locale==='ar'?'نعم، 100% من تبرعاتك تصل للمستحقين عبر شركاء موثوقين ونوفر تقارير دورية وصور ميدانية لكل مشروع.':'Yes, 100% of your donations reach beneficiaries through trusted partners. We provide periodic reports and field photos for each project.',
                            ],
                            [
                                'q' => $locale==='ar'?'هل يمكنني التبرع بشكل شهري متكرر؟':'Can I donate monthly on a recurring basis?',
                                'a' => $locale==='ar'?'نعم، يمكنك تفعيل خاصية التبرع الدوري لدعم المشاريع بشكل مستمر ومنتظم.':'Yes, you can activate the recurring donation feature to support projects continuously and regularly.',
                            ],
                            [
                                'q' => $locale==='ar'?'هل التبرعات آمنة؟':'Are donations secure?',
                                'a' => $locale==='ar'?'نعم، نستخدم أنظمة حماية متقدمة لضمان أمن بيانات المتبرعين وسرية عمليات الدفع.':'Yes, we use advanced protection systems to ensure the security of donor data and the confidentiality of payment operations.',
                            ],
                            [
                                'q' => $locale==='ar'?'هل يمكنني اختيار المشروع الذي أريد التبرع له؟':'Can I choose the project I want to donate to?',
                                'a' => $locale==='ar'?'نعم، يمكنك اختيار المشروع الذي تود دعمه من قائمة المشاريع المتاحة على الموقع.':'Yes, you can choose the project you wish to support from the list of available projects on the website.',
                            ],
                            [
                                'q' => $locale==='ar'?'هل يمكنني التبرع بالنيابة عن شخص آخر؟':'Can I donate on behalf of someone else?',
                                'a' => $locale==='ar'?'نعم، يمكنك التبرع بنية الإهداء لشخص آخر وإرسال رسالة إهداء له.':'Yes, you can donate with the intention of gifting to another person and send them a dedication message.',
                            ],
                            [
                                'q' => $locale==='ar'?'هل يمكنني متابعة حالة تبرعي؟':'Can I follow the status of my donation?',
                                'a' => $locale==='ar'?'نعم، نوفر تحديثات منتظمة حول المشاريع وشهادات موثقة من الجهات المستفيدة.':'Yes, we provide regular updates on projects and documented testimonials from beneficiary organizations.',
                            ],
                            [
                                'q' => $locale==='ar'?'هل توجد رسوم على التبرعات؟':'Are there fees on donations?',
                                'a' => $locale==='ar'?'لا، التبرعات تصل بالكامل إلى المستفيدين، باستثناء أي رسوم يفرضها مزودو خدمة الدفع.':'No, donations reach beneficiaries in full, except for any fees charged by payment service providers.',
                            ],
                            [
                                'q' => $locale==='ar'?'هل يمكنني التبرع من خارج البلاد؟':'Can I donate from outside the country?',
                                'a' => $locale==='ar'?'نعم، الموقع يدعم التبرعات من مختلف دول العالم عبر وسائل الدفع المتاحة.':'Yes, the website supports donations from various countries around the world via available payment methods.',
                            ],
                        ],
                    ],
                    [
                        'group' => $locale==='ar'?'التعاون والشراكة':'Cooperation & Partnership',
                        'icon'  => 'fa-handshake',
                        'items' => [
                            [
                                'q' => $locale==='ar'?'هل يمكن للمؤسسات التعاون معكم؟':'Can organizations cooperate with you?',
                                'a' => $locale==='ar'?'نعم، نرحب بالشراكات مع المؤسسات الخيرية لتنفيذ مشاريع تنموية وإنسانية.':'Yes, we welcome partnerships with charitable organizations to implement development and humanitarian projects.',
                            ],
                            [
                                'q' => $locale==='ar'?'كيف أتطوع مع المؤسسة؟':'How can I volunteer with the foundation?',
                                'a' => $locale==='ar'?'يمكنك التواصل معنا عبر صفحة اتصل بنا للتقديم كمتطوع والمشاركة في الأنشطة الإنسانية.':'You can contact us through the Contact Us page to apply as a volunteer and participate in humanitarian activities.',
                            ],
                        ],
                    ],
                ];
                @endphp

                @php $globalIndex = 0; @endphp
                @foreach($faqGroups as $group)
                <div class="faq-group mb-5">
                    <div class="faq-group-header mb-3">
                        <i class="fa-solid {{ $group['icon'] }} main-color me-2"></i>
                        <span>{{ $group['group'] }}</span>
                    </div>
                    <div class="accordion faq-accordion" id="faqGroup{{ $loop->index }}">
                        @foreach($group['items'] as $faq)
                        @php $fi = $globalIndex++; @endphp
                        <div class="accordion-item faq-item mb-2">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $fi>0?'collapsed':'' }} faq-btn" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faqItem{{ $fi }}">
                                    {{ $faq['q'] }}
                                </button>
                            </h2>
                            <div id="faqItem{{ $fi }}" class="accordion-collapse collapse {{ $fi===0?'show':'' }}">
                                <div class="accordion-body faq-body">{{ $faq['a'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                {{-- More Questions CTA --}}
                <div class="faq-cta-box text-center mt-5">
                    <i class="fa-solid fa-circle-question fa-3x main-color mb-3"></i>
                    <h4>{{ $locale==='ar'?'لديك سؤال آخر؟':'Have another question?' }}</h4>
                    <p class="muted-color mb-4">{{ $locale==='ar'?'إذا لم تجد إجابتك، تواصل معنا وسنرد عليك في أقرب وقت.':'If you didn\'t find your answer, contact us and we\'ll reply as soon as possible.' }}</p>
                    <a href="{{ url($locale.'/contact') }}" class="btn-donate d-inline-block px-5">
                        <i class="fa-solid fa-envelope me-2"></i>
                        {{ $locale==='ar'?'تواصل معنا':'Contact Us' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.page-hero-section { background:linear-gradient(135deg,#f8fdf4,#eef7e6); padding:60px 0 40px; }
.page-hero-section .breadcrumb-item a { color:#5a9e2f; text-decoration:none; }
.faq-group-header { font-size:18px; font-weight:700; color:#333; border-bottom:2px solid #e8f4d9; padding-bottom:10px; }
.faq-cta-box { background:#f8fdf4; border-radius:20px; padding:50px 30px; border:2px dashed rgba(90,158,47,0.3); }
</style>
@endpush
@endsection
