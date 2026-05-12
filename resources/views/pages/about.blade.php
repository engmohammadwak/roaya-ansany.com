@extends('layouts.app')
@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';
@endphp
@section('title', ($isAr ? 'من نحن' : 'About Us') . ' | ' . config('app.name'))

@push('styles')
<style>
/* ===== HERO ===== */
.about-hero {
    background: linear-gradient(135deg, #1a7a4a 0%, #0d4d2e 100%);
    padding: 80px 0 0;
    overflow: hidden;
    position: relative;
}
.about-hero::before {
    content: '';
    position: absolute;
    width: 500px; height: 500px;
    background: rgba(255,255,255,.05);
    border-radius: 50%;
    top: -150px; left: -100px;
}
.about-hero-tag {
    display: inline-block;
    background: rgba(255,255,255,.15);
    color: #fff;
    padding: 6px 18px;
    border-radius: 50px;
    font-size: .85rem;
    letter-spacing: 1px;
    margin-bottom: 20px;
}
.about-hero h1 {
    color: #fff;
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 800;
    line-height: 1.4;
    margin-bottom: 20px;
}
.about-hero h1 span.accent { color: #7fffb8; }
.about-hero p.lead-text {
    color: rgba(255,255,255,.85);
    font-size: 1.05rem;
    line-height: 1.9;
    max-width: 600px;
    margin-bottom: 40px;
}
.about-hero-imgs {
    position: relative;
    height: 340px;
    display: flex;
    align-items: flex-end;
    gap: 12px;
}
.about-hero-imgs img {
    border-radius: 16px 16px 0 0;
    object-fit: cover;
    flex: 1;
}
.about-hero-imgs img:nth-child(1) { height: 240px; }
.about-hero-imgs img:nth-child(2) { height: 300px; }
.about-hero-imgs img:nth-child(3) { height: 200px; }

/* ===== MVG SECTION ===== */
.mvg-section { padding: 80px 0; background: #f8fffe; }
.mvg-card {
    background: #fff;
    border-radius: 20px;
    padding: 32px;
    height: 100%;
    box-shadow: 0 4px 24px rgba(0,0,0,.07);
    border-top: 4px solid #1a7a4a;
    transition: transform .3s, box-shadow .3s;
}
.mvg-card:hover { transform: translateY(-6px); box-shadow: 0 12px 40px rgba(26,122,74,.15); }
.mvg-icon {
    width: 54px; height: 54px;
    background: linear-gradient(135deg, #1a7a4a, #2ecc71);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 18px;
    font-size: 1.5rem;
    color: #fff;
}
.mvg-card h3 {
    font-size: 1.2rem;
    font-weight: 800;
    color: #1a7a4a;
    margin-bottom: 14px;
}
.mvg-card ul { padding: 0; margin: 0; list-style: none; }
.mvg-card ul li {
    color: #555;
    line-height: 1.8;
    font-size: .95rem;
    padding: {{ $isAr ? '5px 22px 5px 0' : '5px 0 5px 22px' }};
    position: relative;
}
.mvg-card ul li::before {
    content: '✓';
    color: #1a7a4a;
    font-weight: 700;
    position: absolute;
    {{ $isAr ? 'right: 0' : 'left: 0' }}: 0;
}
.mvg-card p { color: #555; line-height: 1.9; font-size: .95rem; }

/* ===== WORK FIELDS ===== */
.fields-section { padding: 80px 0; background: #fff; }
.section-header { margin-bottom: 50px; }
.section-header .section-tag {
    display: inline-block;
    background: #e8f5ee;
    color: #1a7a4a;
    padding: 5px 16px;
    border-radius: 50px;
    font-size: .83rem;
    font-weight: 700;
    margin-bottom: 12px;
    letter-spacing: .5px;
}
.section-header h2 {
    font-size: clamp(1.5rem, 3vw, 2.2rem);
    font-weight: 800;
    color: #111;
}
.section-header p { color: #666; font-size: 1rem; max-width: 560px; margin: 10px 0 0; }
.field-card {
    background: #f8fffe;
    border-radius: 18px;
    padding: 28px 24px;
    text-align: center;
    transition: all .3s;
    cursor: default;
    border: 2px solid transparent;
    height: 100%;
}
.field-card:hover {
    background: #fff;
    border-color: #1a7a4a;
    transform: translateY(-5px);
    box-shadow: 0 10px 32px rgba(26,122,74,.12);
}
.field-icon {
    font-size: 2.4rem;
    margin-bottom: 14px;
    display: block;
}
.field-card h4 { font-weight: 700; color: #1a7a4a; font-size: 1rem; margin-bottom: 8px; }
.field-card p { color: #666; font-size: .88rem; line-height: 1.7; margin: 0; }

/* ===== STATS ===== */
.stats-section {
    background: linear-gradient(135deg, #1a7a4a, #0d4d2e);
    padding: 60px 0;
}
.stat-item { text-align: center; color: #fff; padding: 20px; }
.stat-num {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 900;
    color: #7fffb8;
    display: block;
    line-height: 1;
    margin-bottom: 8px;
}
.stat-label { font-size: .95rem; opacity: .85; }
.stat-divider {
    width: 1px;
    background: rgba(255,255,255,.2);
    align-self: stretch;
    margin: 20px 0;
}

/* breadcrumb */
.breadcrumb-section { background: #f0faf5; padding: 12px 0; border-bottom: 1px solid #d4edda; }
.breadcrumb-section a { color: #1a7a4a; text-decoration: none; }

@media(max-width:767px) {
    .about-hero-imgs { height: 180px; gap: 6px; }
    .about-hero-imgs img:nth-child(1) { height: 130px; }
    .about-hero-imgs img:nth-child(2) { height: 160px; }
    .about-hero-imgs img:nth-child(3) { height: 110px; }
    .stat-divider { display: none; }
}
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-section">
    <div class="container">
        <small>
            <a href="{{ url($locale.'/') }}">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
            <span style="margin: 0 8px; color: #888">›</span>
            <span class="text-muted">{{ $isAr ? 'من نحن' : 'About Us' }}</span>
        </small>
    </div>
</div>

{{-- HERO --}}
<section class="about-hero">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-6 pb-5 pb-lg-0">
                <span class="about-hero-tag">{{ $isAr ? 'من نحن' : 'About Us' }}</span>
                <h1>
                    <span class="accent">{{ $isAr ? ($about?->hero_title_highlight_ar ?? 'أمل لفلسطين:') : ($about?->hero_title_highlight_en ?? 'Hope for Palestine:') }}</span><br>
                    {{ $isAr ? ($about?->hero_title_ar ?? 'مؤسسة خيرية عالمية تمكّن المحتاجين') : ($about?->hero_title_en ?? 'A global charity that empowers those in need') }}
                </h1>
                <p class="lead-text">
                    {{ $isAr
                        ? ($about?->hero_description_ar ?? 'منصة خيرية إنسانية دولية تقوم بإنشاء حملات تبرع وتنفيذ مشاريع خيرية مخصصة للمناطق المحتاجة، بهدف تمكين الفئات المستحقة وتعزيز التنمية والتقدم.')
                        : ($about?->hero_description_en ?? 'An international humanitarian charity platform creating donation campaigns and implementing charitable projects to empower those in need and promote development.')
                    }}
                </p>
            </div>
            <div class="col-lg-6">
                <div class="about-hero-imgs">
                    @if($about?->hero_image_1)
                        <img src="{{ Storage::url($about->hero_image_1) }}" alt="">
                        <img src="{{ Storage::url($about->hero_image_1) }}" alt="">
                        <img src="{{ Storage::url($about->hero_image_1) }}" alt="">
                    @else
                        <img src="https://placehold.co/300x240/1a7a4a/fff?text=1" alt="">
                        <img src="https://placehold.co/300x300/15623b/fff?text=2" alt="">
                        <img src="https://placehold.co/300x200/0d4d2e/fff?text=3" alt="">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATS --}}
<section class="stats-section">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <span class="stat-num">{{ $about?->stat_projects ?? '500' }}+</span>
                    <span class="stat-label">{{ $isAr ? 'مشروع منجز' : 'Projects Completed' }}</span>
                </div>
            </div>
            <div class="col-auto d-none d-md-block stat-divider"></div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <span class="stat-num">{{ $about?->stat_beneficiaries ?? '10K' }}+</span>
                    <span class="stat-label">{{ $isAr ? 'مستفيد' : 'Beneficiaries' }}</span>
                </div>
            </div>
            <div class="col-auto d-none d-md-block stat-divider"></div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <span class="stat-num">{{ $about?->stat_countries ?? '20' }}+</span>
                    <span class="stat-label">{{ $isAr ? 'دولة نعمل فيها' : 'Countries' }}</span>
                </div>
            </div>
            <div class="col-auto d-none d-md-block stat-divider"></div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <span class="stat-num">{{ $about?->stat_donors ?? '5K' }}+</span>
                    <span class="stat-label">{{ $isAr ? 'متبرع' : 'Donors' }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MISSION / VISION / GOAL --}}
<section class="mvg-section">
    <div class="container">
        <div class="section-header text-{{ $isAr ? 'end' : 'start' }}">
            <span class="section-tag">{{ $isAr ? 'قيمنا' : 'Our Values' }}</span>
            <h2>{{ $isAr ? 'رؤيتنا ورسالتنا وهدفنا' : 'Our Vision, Mission & Goal' }}</h2>
        </div>
        <div class="row g-4">
            {{-- MISSION --}}
            <div class="col-md-4">
                <div class="mvg-card">
                    <div class="mvg-icon">🎯</div>
                    <h3>{{ $isAr ? ($about?->mission_title_ar ?? 'رسالتنا') : ($about?->mission_title_en ?? 'Our Mission') }}</h3>
                    <p>{{ $isAr ? ($about?->mission_text_ar ?? 'الوصول إلى الفئات المستحقة وذوي الدخل المحدود لتحقيق الاكتفاء الذاتي وبناء مصادر دخل مستقلة.') : ($about?->mission_text_en ?? 'Reaching those in need to achieve self-sufficiency and build independent income sources.') }}</p>
                </div>
            </div>
            {{-- VISION --}}
            <div class="col-md-4">
                <div class="mvg-card">
                    <div class="mvg-icon">👁️</div>
                    <h3>{{ $isAr ? ($about?->vision_title_ar ?? 'رؤيتنا') : ($about?->vision_title_en ?? 'Our Vision') }}</h3>
                    <p>{{ $isAr ? ($about?->vision_text_ar ?? 'التنمية والريادة في العمل الإنساني على المستوى الدولي.') : ($about?->vision_text_en ?? 'Development and leadership in international humanitarian work.') }}</p>
                </div>
            </div>
            {{-- GOAL --}}
            <div class="col-md-4">
                <div class="mvg-card">
                    <div class="mvg-icon">🌟</div>
                    <h3>{{ $isAr ? ($about?->goal_title_ar ?? 'هدفنا') : ($about?->goal_title_en ?? 'Our Goal') }}</h3>
                    <ul>
                        @if($about?->goal_points_ar)
                            @foreach(json_decode($isAr ? $about->goal_points_ar : $about->goal_points_en, true) ?? [] as $point)
                                <li>{{ $point }}</li>
                            @endforeach
                        @else
                            <li>{{ $isAr ? 'بناء شراكات فعالة مع المنظمات الإنسانية.' : 'Build effective partnerships with humanitarian organizations.' }}</li>
                            <li>{{ $isAr ? 'تحقيق الاكتفاء الذاتي لعائلات المحتاجين.' : 'Achieve self-sufficiency for families in need.' }}</li>
                            <li>{{ $isAr ? 'تطوير المشاريع الخدمية من مدارس ومستشفيات.' : 'Develop service projects like schools and hospitals.' }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- WORK FIELDS --}}
@if($workFields->count() > 0)
<section class="fields-section">
    <div class="container">
        <div class="section-header text-{{ $isAr ? 'end' : 'start' }}">
            <span class="section-tag">{{ $isAr ? 'مجالاتنا' : 'Our Fields' }}</span>
            <h2>{{ $isAr ? 'مجالات التبرع' : 'Donation Fields' }}</h2>
            <p>{{ $isAr ? 'المجالات والمشاريع التي سيتم دعمها من خلال التبرعات.' : 'Fields and projects that will be supported through donations.' }}</p>
        </div>
        <div class="row g-4">
            @foreach($workFields as $field)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="field-card">
                    <span class="field-icon">{{ $field->icon ?? '🌿' }}</span>
                    <h4>{{ $isAr ? $field->title_ar : $field->title_en }}</h4>
                    @if($field->description_ar)
                    <p>{{ $isAr ? $field->description_ar : $field->description_en }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
