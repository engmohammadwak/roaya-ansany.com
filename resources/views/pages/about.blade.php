@extends('layouts.app')
@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';

    $ctaTitle = $isAr
        ? ($hs->cta_title_ar ?? ($about?->cta_title_ar ?? 'تبرّع الآن — أنقذ حياة'))
        : ($hs->cta_title_en ?? ($about?->cta_title_en ?? 'Donate Now — Save a Life'));

    $ctaDesc = $isAr
        ? ($hs->cta_description_ar ?? ($about?->cta_description_ar ?? ''))
        : ($hs->cta_description_en ?? ($about?->cta_description_en ?? ''));

    $ctaImg = $hs->cta_image
        ? asset('storage/' . $hs->cta_image)
        : asset('website/images/donate-child.svg');
@endphp
@section('title', ($isAr ? 'من نحن' : 'About Us') . ' | ' . config('app.name'))

@section('content')

<div class="about-main">

    {{-- BREADCRUMBS --}}
    <div class="container first-container">
        <div class="breadcrumbs mt-4">
            <a href="{{ url($locale) }}">
                <img class="me-2" src="{{ asset('website/images/home.svg') }}" alt="home">
                {{ $isAr ? 'الرئيسية' : 'Home' }}
            </a>
            <span>/</span>
            <a href="#" class="active">
                {{ $isAr ? 'من نحن' : 'About Us' }}
            </a>
        </div>
    </div>

    {{-- ===== HERO SECTION ===== --}}
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 text-lg-start text-center col-lg-6 mb-4">

                    <h1 class="d-inline-block h1-title mt-4 text-center text-lg-start">
                        {{ $isAr
                            ? ($about?->hero_title_ar ?? 'مؤسسة رؤيا الإنسانية')
                            : ($about?->hero_title_en ?? 'Roaya Humanitarian Foundation')
                        }}
                        <img class="ms-3 d-none d-lg-inline" src="{{ asset('website/images/blue.svg') }}" alt="icon">
                    </h1>

                    <p class="muted-color mt-3">
                        {{ $isAr
                            ? ($about?->hero_description_ar ?? 'رؤيا مؤسسة خيرية غير ربحية تعمل في المجال الإنساني، وتقدّم مساعدات منقذة للحياة للفقراء والأيتام والمحتاجين والنازحين في المناطق المتأثرة بالنزاعات والحروب والكوارث. وتموّل المؤسسة مشاريعها من خلال التبرعات المقدمة من الداعمين الكرماء.')
                            : ($about?->hero_description_en ?? 'Roaya is a non-profit humanitarian charity that provides life-saving assistance to the poor, orphans, and displaced people in areas affected by conflicts, wars, and disasters.')
                        }}
                    </p>

                    <form action="{{ url($locale . '/donate') }}" class="mt-4">
                        <div class="row">
                            <div class="col-lg-9 col-8">
                                <input type="text" name="amount" id="amonut" class="form-input w-100"
                                    placeholder="{{ $isAr ? 'ادخل المبلغ' : 'Enter Amount' }}">
                            </div>
                            <div class="col-lg-3 col-4">
                                <button type="submit" class="btn-donate w-100">
                                    {{ $isAr ? 'تبرع الآن' : 'Donate Now' }}
                                </button>
                            </div>
                            <div class="col-12">
                                <div class="progress-container mt-4">
                                    <div class="progress-bar">
                                        <div style="width: 100%;" class="progress-fill"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="col-md-6 text-end position-relative">
                    @if($about?->hero_image_1)
                        <img src="{{ Storage::url($about->hero_image_1) }}" class="img-fluid" alt="{{ $isAr ? 'عن مؤسسة رؤيا' : 'About Roaya' }}">
                    @else
                        <img src="{{ asset('website/images/about-hero.png') }}" class="img-fluid" alt="{{ $isAr ? 'عن مؤسسة رؤيا' : 'About Roaya' }}">
                    @endif

                    <div class="users-rate">
                        <div class="d-flex align-items-center mb-3">
                            <div class="content">
                                <p class="mb-2">
                                    {{ $isAr
                                        ? ($about?->hero_badge_title_ar ?? 'نسعى إلى مدّ يد العون للمحتاجين والمنكوبين')
                                        : ($about?->hero_badge_title_en ?? 'We reach out to those in need')
                                    }}
                                </p>
                                <p>
                                    {{ $isAr
                                        ? ($about?->hero_badge_subtitle_ar ?? 'أينما كانوا')
                                        : ($about?->hero_badge_subtitle_en ?? 'Wherever they are')
                                    }}
                                </p>
                            </div>
                        </div>
                        <div class="stars">
                            @for ($i = 0; $i < 6; $i++)
                                <img class="me-2 mb-3" width="34" height="34"
                                    src="{{ asset('website/images/star-rate.svg') }}" alt="star">
                            @endfor
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== VISION & GOALS ===== --}}
    <section class="main-section">
        <div class="container">
            <div class="about-roaya">

                <h2 class="section-title text-center mb-4">
                    {{ $isAr ? 'الرؤية و الأهداف' : 'Vision & Goals' }}
                </h2>

                <p class="muted-color text-center mx-auto">
                    {{ $isAr
                        ? ($about?->vision_section_desc_ar ?? 'نسعى إلى بناء مجتمع أكثر تكافلاً وعدلاً من خلال تمكين الأفراد والمؤسسات من المساهمة في العمل الإنساني، وتحقيق التنمية المستدامة عبر مشاريع تلامس احتياجات الإنسان في مختلف المجالات.')
                        : ($about?->vision_section_desc_en ?? 'We strive to build a more equitable society by empowering individuals and institutions to contribute to humanitarian work and achieving sustainable development.')
                    }}
                </p>

                <div class="stats mt-5">
                    <div class="row">

                        <div class="col-md-4 mb-4">
                            <div class="stat vision">
                                <div class="intro mb-5">
                                    <h3 class="text-white mb-4">{{ $isAr ? 'رؤيتنا' : 'Our Vision' }}</h3>
                                    <p class="color-67">
                                        {{ $isAr
                                            ? ($about?->vision_text_ar ?? 'استجابة إنسانية شاملة تحمي كرامة الإنسان، وتعزز صموده، وتساهم في بناء مجتمع أكثر عدلاً وأماناً في تركيا وسوريا وفلسطين.')
                                            : ($about?->vision_text_en ?? 'A comprehensive humanitarian response that protects human dignity, enhances resilience, and contributes to building a more just and secure society.')
                                        }}
                                    </p>
                                </div>
                                <div class="stats-imgs">
                                    <a href="{{ url($locale . '/donate') }}" class="btn-donate">
                                        {{ $isAr ? 'تبرع الآن' : 'Donate Now' }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="stat d-block our-msg">
                                <div class="intro">
                                    <div class="imgs mb-3">
                                        @for ($i = 0; $i < 5; $i++)
                                            <img src="{{ asset('website/images/star-white.svg') }}" alt="star">
                                        @endfor
                                    </div>
                                    <ul class="text-dark">
                                        @php
                                            $goalPoints = $isAr
                                                ? ($about?->goal_points_ar ?? [])
                                                : ($about?->goal_points_en ?? []);
                                        @endphp
                                        @if(!empty($goalPoints))
                                            @foreach($goalPoints as $point)
                                                <li>{{ is_array($point) ? ($point['item'] ?? '') : $point }}</li>
                                            @endforeach
                                        @else
                                            <li>{{ $isAr ? 'تنفيذ مشاريع إنسانية وتنموية مستدامة تُحدث أثراً حقيقياً في حياة الفقراء والمحتاجين.' : 'Implement humanitarian and sustainable development projects.' }}</li>
                                            <li>{{ $isAr ? 'تقديم المساعدات العاجلة للنازحين وضحايا الحروب والكوارث.' : 'Provide emergency aid to displaced people and victims of wars and disasters.' }}</li>
                                            <li>{{ $isAr ? 'دعم الأيتام والأرامل والفئات الأكثر ضعفاً عبر برامج كفالة ورعاية متكاملة.' : 'Support orphans, widows and the most vulnerable through comprehensive care programs.' }}</li>
                                            <li>{{ $isAr ? 'تعزيز قيم العمل التطوعي والمسؤولية الاجتماعية في المجتمعات المحلية والعالمية.' : 'Promote volunteerism and social responsibility locally and globally.' }}</li>
                                        @endif
                                    </ul>
                                    <h3 class="text-white">{{ $isAr ? 'أهدافنا' : 'Our Goals' }}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="stat mission">
                                <div class="intro mb-5">
                                    <h3 class="mb-4">{{ $isAr ? 'رسالتنا' : 'Our Mission' }}</h3>
                                    <p class="color-67">
                                        {{ $isAr
                                            ? ($about?->mission_text_ar ?? 'تقديم تدخلات إنسانية وتنموية تستند إلى الاحتياج الحقيقي، وقائمة على المهنية والشفافية، والتزام بالمعايير الدولية، بما يضمن وصول المساعدات إلى مستحقيها، ويُحقق أثراً مُلموساً في حياة الفئات الأكثر هشاشة.')
                                            : ($about?->mission_text_en ?? 'Providing humanitarian and developmental interventions based on real need, professionalism, transparency, and international standards, ensuring assistance reaches those who deserve it.')
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== WHERE WE WORK / STORY ===== --}}
    <section class="main-section where-work">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <div class="where-card">

                        <h6 class="mb-3">{{ $isAr ? 'نبذة قصيرة' : 'Brief Overview' }}</h6>

                        <h2 class="section-title mb-4">
                            {{ $isAr ? 'مؤسسة رؤيا الإنسانية' : 'Roaya Humanitarian Foundation' }}
                        </h2>

                        <p class="muted-color mb-3">
                            {{ $isAr
                                ? ($about?->story_paragraph_1_ar ?? 'مؤسسة رؤيا الإنسانية هي مؤسسة أهلية غير ربحية تعمل في إطار القوانين التركية، وتُعنى بتقديم خدمات إنسانية وإغاثية للفئات الأكثر هشاشةً، مع التركيز على دعم الأسر المتضررة والمحتاجة داخل تركيا، إلى جانب المجتمعات المحتاجة في سوريا وفلسطين.')
                                : ($about?->story_paragraph_1_en ?? 'Roaya Humanitarian Foundation is a non-profit civil organization operating under Turkish law, focused on providing humanitarian and relief services to the most vulnerable groups.')
                            }}
                        </p>

                        <p>{{ $isAr
                            ? ($about?->story_paragraph_2_ar ?? 'ويعتمد تنفيذ هذه البرامج على تقييمات احتياج دورية، وشبكة واسعة من الشركاء المحليين والدوليين، ومنهجيات تتماشى مع معايير العمل الإنساني.')
                            : ($about?->story_paragraph_2_en ?? 'Implementation of these programs relies on periodic needs assessments, a wide network of local and international partnerships, and methodologies aligned with humanitarian work standards.')
                        }}</p>

                        <p class="muted-color mt-4">
                            {{ $isAr
                                ? ($about?->story_cta_text_ar ?? 'ساعدنا في تقديم المساعدة العاجلة للمحتاجين والمتضررين من النزاعات والكوارث الطبيعية من خلال التبرع اليوم.')
                                : ($about?->story_cta_text_en ?? 'Help us provide urgent assistance to those in need and affected by conflicts and natural disasters by donating today.')
                            }}
                        </p>

                        <form action="{{ url($locale . '/donate') }}">
                            <input type="text" name="amount" class="form-input w-100 mt-4"
                                placeholder="{{ $isAr ? 'ادخل المبلغ' : 'Enter Amount' }}">
                            <div class="progress-container mt-4">
                                <div class="progress-bar">
                                    <div style="width: 100%" class="progress-fill"></div>
                                </div>
                            </div>
                            <button type="submit" class="btn-donate text-center mt-3 w-100">
                                {{ $isAr ? 'تبرع' : 'Donate' }}
                            </button>
                        </form>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="why-imgs">
                        @if($about?->story_image)
                            <img src="{{ Storage::url($about->story_image) }}" class="img-fluid" alt="">
                        @else
                            <img src="{{ asset('website/images/about-hero.png') }}" class="img-fluid" alt="">
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== CTA DONATE SECTION ===== --}}
    <section class="main-section">
        <div class="container">
            <div class="donate overflow-hidden">

                <div class="content">
                    <h2 class="main-title text-white mb-4">{{ $ctaTitle }}</h2>

                    @if($ctaDesc)
                    <p class="text-white mb-4" style="font-size:15px;line-height:1.9;opacity:.9">{{ $ctaDesc }}</p>
                    @endif

                    <div class="mt-4 holder">
                        <input type="text" name="amount" id="amount888" class="form-input"
                            placeholder="{{ $isAr ? 'ادخل المبلغ' : 'Enter Amount' }}">
                        <button type="button" class="btn-donate">
                            {{ $isAr ? 'تبرع' : 'Donate' }}
                        </button>
                    </div>
                </div>

                <img src="{{ $ctaImg }}" class="d-none d-lg-block" alt="donate image">

            </div>
        </div>
    </section>

</div>

@endsection
