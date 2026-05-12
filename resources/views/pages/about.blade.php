@extends('layouts.app')
@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';
@endphp
@section('title', ($isAr ? 'من نحن' : 'About Us') . ' | ' . config('app.name'))

@push('styles')
<style>
/* =============== BREADCRUMB =============== */
.breadcrumb-bar {
    background: #f7f7f7;
    padding: 10px 0;
    font-size: .88rem;
    border-bottom: 1px solid #eee;
}
.breadcrumb-bar a { color: #333; text-decoration: none; }
.breadcrumb-bar .sep { margin: 0 6px; color: #aaa; }
.breadcrumb-bar .current { color: #555; }

/* =============== HERO =============== */
.about-hero {
    padding: 60px 0 50px;
    background: #fff;
}
.hero-img-wrap {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
}
.hero-img-wrap img {
    width: 100%;
    height: 360px;
    object-fit: cover;
    border-radius: 12px;
    display: block;
}
.hero-img-caption {
    position: absolute;
    bottom: 14px;
    right: 14px;
    background: rgba(0,0,0,.55);
    color: #fff;
    font-size: .78rem;
    padding: 4px 10px;
    border-radius: 6px;
}
.hero-avatars {
    display: flex;
    gap: 6px;
    margin-top: 14px;
    align-items: center;
}
.hero-avatars img {
    width: 36px; height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    margin-right: -8px;
    box-shadow: 0 2px 6px rgba(0,0,0,.15);
}
.hero-avatars span {
    margin-right: 20px;
    font-size: .8rem;
    color: #666;
}
.hero-content { padding: {{ $isAr ? '0 40px 0 0' : '0 0 0 40px' }}; }
.hero-content .star-badge {
    color: #4caf50;
    font-size: 1.4rem;
    margin-bottom: 10px;
    display: block;
}
.hero-content h1 {
    font-size: clamp(1.6rem, 3.5vw, 2.4rem);
    font-weight: 900;
    color: #111;
    margin-bottom: 16px;
    line-height: 1.35;
}
.hero-content p {
    color: #555;
    font-size: .97rem;
    line-height: 1.9;
    margin-bottom: 28px;
}
.hero-btns { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
.btn-donate-hero {
    background: #4caf50;
    color: #fff;
    padding: 12px 32px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 1rem;
    border: none;
    text-decoration: none;
    display: inline-block;
    transition: background .25s;
}
.btn-donate-hero:hover { background: #388e3c; color: #fff; }
.btn-amount-hero {
    background: #fff;
    color: #333;
    padding: 11px 28px;
    border-radius: 8px;
    font-size: .95rem;
    border: 1.5px solid #ddd;
    text-decoration: none;
    display: inline-block;
    transition: border-color .25s;
}
.btn-amount-hero:hover { border-color: #4caf50; color: #333; }
.green-line {
    width: 56px; height: 4px;
    background: #4caf50;
    border-radius: 2px;
    margin-top: 22px;
}

/* =============== VISION SECTION =============== */
.vision-section { padding: 70px 0; background: #fafafa; }
.vision-section .sec-title {
    font-size: clamp(1.4rem, 3vw, 2rem);
    font-weight: 800;
    color: #111;
    margin-bottom: 10px;
}
.vision-section .sec-sub {
    color: #666;
    font-size: .95rem;
    max-width: 600px;
    margin: 0 auto 40px;
    line-height: 1.8;
}

/* Cards */
.mvg-card {
    border-radius: 16px;
    padding: 30px 26px;
    height: 100%;
    position: relative;
    overflow: hidden;
}
.mvg-card.card-light  { background: #f5f0e8; }
.mvg-card.card-green  { background: #4caf50; color: #fff; }
.mvg-card.card-dark   { background: #1a1a1a; color: #fff; }

.mvg-card .card-label {
    font-size: .82rem;
    font-weight: 700;
    letter-spacing: .5px;
    margin-bottom: 14px;
    display: block;
    opacity: .75;
}
.mvg-card.card-light .card-label { color: #555; }
.mvg-card.card-green .card-label { color: rgba(255,255,255,.8); }
.mvg-card.card-dark  .card-label { color: rgba(255,255,255,.65); }

.mvg-card h3 {
    font-size: 1.18rem;
    font-weight: 800;
    margin-bottom: 16px;
}
.mvg-card.card-light  h3 { color: #222; }
.mvg-card.card-green  h3 { color: #fff; }
.mvg-card.card-dark   h3 { color: #fff; }

.mvg-card p, .mvg-card ul li {
    font-size: .92rem;
    line-height: 1.85;
}
.mvg-card.card-light  p,
.mvg-card.card-light  ul li { color: #555; }
.mvg-card.card-green  p,
.mvg-card.card-green  ul li { color: rgba(255,255,255,.9); }
.mvg-card.card-dark   p,
.mvg-card.card-dark   ul li { color: rgba(255,255,255,.8); }

.mvg-card ul { padding: 0; margin: 0 0 20px; list-style: none; }
.mvg-card ul li {
    padding-{{ $isAr ? 'right' : 'left' }}: 18px;
    position: relative;
    margin-bottom: 6px;
}
.mvg-card ul li::before {
    content: '•';
    position: absolute;
    {{ $isAr ? 'right' : 'left' }}: 0;
    color: currentColor;
    opacity: .7;
}
.card-green ul li::before { color: #fff; }

.mvg-card .stars { font-size: 1.1rem; margin-bottom: 12px; }
.mvg-card .btn-card {
    display: inline-block;
    margin-top: 10px;
    padding: 9px 22px;
    border-radius: 7px;
    font-size: .88rem;
    font-weight: 700;
    text-decoration: none;
    transition: all .25s;
}
.card-green .btn-card  { background: #388e3c; color: #fff; }
.card-green .btn-card:hover { background: #2e7d32; }
.card-dark  .btn-card  { background: #4caf50; color: #fff; }
.card-dark  .btn-card:hover { background: #388e3c; }

/* =============== STORY SECTION =============== */
.story-section { padding: 70px 0; background: #fff; }
.story-img-wrap {
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    height: 460px;
}
.story-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}
.story-img-overlay {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 22px 24px;
    background: linear-gradient(to top, rgba(0,0,0,.75), transparent);
    color: #fff;
}
.story-img-overlay h4 {
    font-size: 1.5rem;
    font-weight: 900;
    line-height: 1.3;
    margin: 0;
}
.story-img-overlay span {
    font-size: .85rem;
    opacity: .85;
    display: block;
    margin-top: 4px;
}
.story-content { padding: {{ $isAr ? '0 40px 0 0' : '0 0 0 40px' }}; }
.story-content h2 {
    font-size: clamp(1.4rem, 3vw, 2rem);
    font-weight: 900;
    color: #111;
    margin-bottom: 22px;
}
.story-content p {
    color: #555;
    font-size: .93rem;
    line-height: 1.95;
    margin-bottom: 14px;
}
.story-content .btn-donate-story {
    display: inline-block;
    background: #4caf50;
    color: #fff;
    padding: 12px 34px;
    border-radius: 8px;
    font-weight: 700;
    font-size: .97rem;
    text-decoration: none;
    margin-top: 16px;
    transition: background .25s;
}
.story-content .btn-donate-story:hover { background: #388e3c; }
.story-content .btn-amount-story {
    display: inline-block;
    border: 1.5px solid #ddd;
    color: #333;
    padding: 11px 26px;
    border-radius: 8px;
    font-size: .93rem;
    text-decoration: none;
    margin-top: 16px;
    margin-{{ $isAr ? 'right' : 'left' }}: 10px;
    transition: border-color .25s;
}
.story-content .btn-amount-story:hover { border-color: #4caf50; }

/* =============== CTA SECTION =============== */
.cta-section {
    background: #1a1a1a;
    padding: 70px 0;
    position: relative;
    overflow: hidden;
}
.cta-section .cta-img {
    border-radius: 16px;
    overflow: hidden;
    height: 340px;
}
.cta-section .cta-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    opacity: .85;
}
.cta-content { padding: {{ $isAr ? '0 50px 0 0' : '0 0 0 50px' }}; color: #fff; }
.cta-content h2 {
    font-size: clamp(1.4rem, 3vw, 2rem);
    font-weight: 900;
    margin-bottom: 16px;
    line-height: 1.4;
}
.cta-content h2 span { color: #4caf50; }
.cta-content p {
    color: rgba(255,255,255,.75);
    font-size: .93rem;
    line-height: 1.9;
    margin-bottom: 24px;
}
.cta-btns { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
.btn-cta-green {
    background: #4caf50;
    color: #fff;
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 700;
    font-size: .97rem;
    text-decoration: none;
    border: none;
    transition: background .25s;
    display: inline-block;
}
.btn-cta-green:hover { background: #388e3c; color: #fff; }
.btn-cta-outline {
    border: 1.5px solid rgba(255,255,255,.3);
    color: rgba(255,255,255,.85);
    padding: 11px 26px;
    border-radius: 8px;
    font-size: .93rem;
    text-decoration: none;
    display: inline-block;
    transition: border-color .25s;
}
.btn-cta-outline:hover { border-color: #4caf50; color: #fff; }

@media (max-width: 767px) {
    .hero-content { padding: 30px 0 0; }
    .story-content { padding: 30px 0 0; }
    .cta-content  { padding: 30px 0 0; }
    .story-img-wrap { height: 260px; }
    .cta-section .cta-img { height: 220px; }
}
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-bar">
    <div class="container">
        <a href="{{ url('/') }}">🏠</a>
        <span class="sep">›</span>
        <span class="current">{{ $isAr ? 'من نحن' : 'About Us' }}</span>
    </div>
</div>

{{-- ======= HERO ======= --}}
<section class="about-hero">
    <div class="container">
        <div class="row align-items-center {{ $isAr ? 'flex-row-reverse' : '' }}">
            {{-- Image col --}}
            <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
                <div class="hero-img-wrap">
                    @if($about?->hero_image_1)
                        <img src="{{ Storage::url($about->hero_image_1) }}" alt="رؤيا الإنسانية">
                    @else
                        <img src="https://placehold.co/520x360/4caf50/fff?text=رؤيا+الإنسانية" alt="رؤيا الإنسانية">
                    @endif
                    <span class="hero-img-caption">{{ $isAr ? 'نسعى إلى مد يد العون للمحتاجين والمنكوبين' : 'We reach out to those in need' }}</span>
                </div>
                <div class="hero-avatars">
                    @for($i = 0; $i < 5; $i++)
                        <img src="https://placehold.co/36x36/{{ ['4caf50','388e3c','66bb6a','2e7d32','81c784'][$i] }}/fff?text={{ $i+1 }}" alt="">
                    @endfor
                    <span style="margin-right:20px">{{ $isAr ? 'أُسرة ثانية' : 'Second family' }}</span>
                </div>
            </div>

            {{-- Text col --}}
            <div class="col-lg-7 col-md-6">
                <div class="hero-content">
                    <span class="star-badge">✳</span>
                    <h1>{{ $isAr ? ($about?->hero_title_ar ?? 'مؤسسة رؤيا الإنسانية') : ($about?->hero_title_en ?? 'Roaya Humanitarian Foundation') }}</h1>
                    <p>{{ $isAr
                        ? ($about?->hero_description_ar ?? 'رؤيا مؤسسة خيرية غير ربحية تعمل في المجال الإنساني، وتقدّم مساعدات متنوعة للفقراء والأيتام والمحتاجين والنازحين في المناطق المتأثرة بالأزمات والحروب والكوارث. وتموّل المؤسسة مشاريعها من خلال التبرعات المقدمة من الداعمين الكرماء.')
                        : ($about?->hero_description_en ?? 'Roaya is a non-profit humanitarian organization that provides diverse assistance to the poor, orphans, and displaced people in areas affected by crises, wars and disasters.')
                    }}</p>
                    <div class="hero-btns">
                        <a href="{{ url('/donate') }}" class="btn-donate-hero">{{ $isAr ? 'تبرع الآن' : 'Donate Now' }}</a>
                        <a href="#" class="btn-amount-hero">{{ $isAr ? 'ادخل المبلغ' : 'Enter Amount' }}</a>
                    </div>
                    <div class="green-line"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ======= VISION / MISSION / GOALS ======= --}}
<section class="vision-section">
    <div class="container">
        <div class="text-center mb-2">
            <h2 class="sec-title">{{ $isAr ? 'الرؤية و الأهداف' : 'Vision & Goals' }}</h2>
            <p class="sec-sub">{{ $isAr
                ? ($about?->vision_section_desc_ar ?? 'نسعى إلى بناء مجتمع أكثر تكافؤاً وعدلاً من خلال تمكين الأفراد والمؤسسات للمساهمة في العمل الإنساني وتحقيق التنمية المستدامة عبر مشاريع تلبّي احتياجات الإنسان في مختلف المجالات.')
                : ($about?->vision_section_desc_en ?? 'We strive to build a more equitable society by empowering individuals and institutions to contribute to humanitarian work and achieve sustainable development.')
            }}</p>
        </div>
        <div class="row g-3">
            {{-- رسالتنا --}}
            <div class="col-md-4">
                <div class="mvg-card card-light h-100">
                    <span class="card-label">{{ $isAr ? 'رسالتنا' : 'Our Mission' }}</span>
                    <h3>{{ $isAr ? ($about?->mission_title_ar ?? 'رسالتنا') : ($about?->mission_title_en ?? 'Our Mission') }}</h3>
                    <p>{{ $isAr
                        ? ($about?->mission_text_ar ?? 'تقديم تدخلات إنسانية وتنموية مستندة إلى الاحتياج الحقيقي، والقائمة على المهنية والشفافية، والتزام بالمعايير الدولية، بما يضمن وصول المساعدات إلى مستحقيها، ويحقق أثراً مُلموساً في حياة الفئات الأكثر هشاشة.')
                        : ($about?->mission_text_en ?? 'Providing humanitarian and developmental interventions based on real need, professionalism, and transparency, ensuring assistance reaches those most in need.')
                    }}</p>
                </div>
            </div>

            {{-- أهدافنا --}}
            <div class="col-md-4">
                <div class="mvg-card card-green h-100">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <span class="card-label">{{ $isAr ? 'أهدافنا' : 'Our Goals' }}</span>
                    <ul>
                        @if($about?->goal_points_ar)
                            @foreach(json_decode($isAr ? $about->goal_points_ar : $about->goal_points_en, true) ?? [] as $point)
                                <li>{{ $point }}</li>
                            @endforeach
                        @else
                            <li>{{ $isAr ? 'تنفيذ مشاريع إنسانية وتنموية مستدامة تُحدث أثراً إيجابياً في حياة الفقراء والمحتاجين.' : 'Implement sustainable humanitarian projects.' }}</li>
                            <li>{{ $isAr ? 'تقديم المساعدات العاجلة للنازحين وضحايا الحروب والكوارث.' : 'Provide urgent assistance to displaced people.' }}</li>
                            <li>{{ $isAr ? 'دعم الأيتام والأرامل والفئات الأكثر ضعفاً عبر برامج كفالة ورعاية متكاملة.' : 'Support orphans and widows through comprehensive care programs.' }}</li>
                            <li>{{ $isAr ? 'تعزيز قيم العمل التطوعي والمسؤولية الاجتماعية في المجتمعات المحلية والعالمية.' : 'Promote volunteerism and social responsibility.' }}</li>
                        @endif
                    </ul>
                    <a href="{{ url('/donate') }}" class="btn-card">{{ $isAr ? 'أهدافنا' : 'Our Goals' }}</a>
                </div>
            </div>

            {{-- رؤيتنا --}}
            <div class="col-md-4">
                <div class="mvg-card card-dark h-100">
                    <span class="card-label">{{ $isAr ? 'رؤيتنا' : 'Our Vision' }}</span>
                    <h3>{{ $isAr ? ($about?->vision_title_ar ?? 'رؤيتنا') : ($about?->vision_title_en ?? 'Our Vision') }}</h3>
                    <p>{{ $isAr
                        ? ($about?->vision_text_ar ?? 'استجابة إنسانية شاملة تحمي كرامة الإنسان، وتعزز صموده، وتساهم في بناء مجتمع أكثر عدلاً وأملاً في تركيا وفلسطين.')
                        : ($about?->vision_text_en ?? 'A comprehensive humanitarian response that protects human dignity and contributes to building a more just society.')
                    }}</p>
                    <a href="{{ url('/donate') }}" class="btn-card">{{ $isAr ? 'تبرع الآن' : 'Donate Now' }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ======= STORY / ABOUT SECTION ======= --}}
<section class="story-section">
    <div class="container">
        <div class="row align-items-center {{ $isAr ? '' : 'flex-row-reverse' }}">
            {{-- Image --}}
            <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
                <div class="story-img-wrap">
                    @if($about?->story_image)
                        <img src="{{ Storage::url($about->story_image) }}" alt="">
                    @else
                        <img src="https://placehold.co/520x460/1a1a1a/4caf50?text=رؤيا+الإنسانية" alt="">
                    @endif
                    <div class="story-img-overlay">
                        <h4>{{ $isAr ? 'رؤيا الإنسانية' : 'Roaya Humanitarian' }}<br>{{ $isAr ? 'نصل حيث يكون الاحتياج' : 'We reach where there is need' }}</h4>
                        <span>{{ $isAr ? 'لأنك مصدر الأمل' : 'Because you are the source of hope' }}</span>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="col-lg-7 col-md-6">
                <div class="story-content">
                    <h2>{{ $isAr ? 'مؤسسة رؤيا الإنسانية' : 'Roaya Humanitarian Foundation' }}</h2>
                    <p>{{ $isAr
                        ? ($about?->story_paragraph_1_ar ?? 'مؤسسة رؤيا الإنسانية هي مؤسسة أهلية غير ربحية تعمل في إطار القوانين التركية، وتسعى لتقديم خدمات إنسانية وإغاثية للفئات الأكثر هشاشةً مع التركيز على دعم الأمر المتضررة والمحتاجة داخل تركيا إلى جانب المجتمعات المحتاجة في سوريا وفلسطين.')
                        : ($about?->story_paragraph_1_en ?? 'Roaya Humanitarian Foundation is a non-profit civil organization operating under Turkish law, seeking to provide humanitarian and relief services to the most vulnerable groups.')
                    }}</p>
                    <p>{{ $isAr
                        ? ($about?->story_paragraph_2_ar ?? 'تعتمد المؤسسة على شبكة واسعة من الشركاء المحليين والدوليين لتمكيا من تنفيذ مشاريع أكثر أثراً وللاستفادة من الخبرات المتراكمة في مجال العمل الإنساني. وتطمح رؤيا الإنسانية إلى أن تكون جزءاً فاعلاً في الجهود الإنسانية لإفادة الفئات الثلاث وتعزيز روح التضامن.')
                        : ($about?->story_paragraph_2_en ?? 'The foundation relies on a wide network of local and international partners to implement more impactful projects and benefit from accumulated expertise in humanitarian work.')
                    }}</p>
                    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:8px">
                        <a href="{{ url('/donate') }}" class="btn-donate-story">{{ $isAr ? 'تبرع' : 'Donate' }}</a>
                        <a href="#" class="btn-amount-story">{{ $isAr ? 'ادخل المبلغ' : 'Enter Amount' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ======= CTA SECTION ======= --}}
<section class="cta-section">
    <div class="container">
        <div class="row align-items-center {{ $isAr ? '' : 'flex-row-reverse' }}">
            {{-- Image --}}
            <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
                <div class="cta-img">
                    @if($about?->cta_image)
                        <img src="{{ Storage::url($about->cta_image) }}" alt="">
                    @else
                        <img src="https://placehold.co/520x340/2e7d32/fff?text=تبرع+الآن" alt="">
                    @endif
                </div>
            </div>

            {{-- Text --}}
            <div class="col-lg-7 col-md-6">
                <div class="cta-content">
                    <h2>{{ $isAr ? 'تبرّع الآن — ' : 'Donate Now — ' }}<span>{{ $isAr ? 'أنقذ حياة' : 'Save Lives' }}</span></h2>
                    <p>{{ $isAr
                        ? ($about?->cta_description_ar ?? 'تبرع الآن وأنقذ حياة. في مكان ما هناك شخص يتطلع ويأمله وإعادته الأمل في الحياة. التبرع لرؤيا الإنسانية بمبالغ ضئيلة مهما كانت صغيرة تضاعف الثقة بالمؤسسة. كل فعل خيرية إنسامة — كل فعل خيرية إنسامة.')
                        : ($about?->cta_description_en ?? 'Donate now and save a life. Somewhere there is a person who hopes for your help. Every act of charity is a contribution.')
                    }}</p>
                    <div class="cta-btns">
                        <a href="{{ url('/donate') }}" class="btn-cta-green">{{ $isAr ? 'تبرع' : 'Donate' }}</a>
                        <a href="#" class="btn-cta-outline">{{ $isAr ? 'ادخل المبلغ' : 'Enter Amount' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
