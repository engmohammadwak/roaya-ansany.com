@extends('layouts.app')
@php $locale = app()->getLocale(); $isAr = $locale === 'ar'; @endphp
@section('title', ($isAr ? 'من نحن' : 'About Us') . ' | مؤسسة رؤيا الإنسانية')

@push('styles')
<style>
.about-hero {
    background: linear-gradient(135deg, #1a7a4a 0%, #2ecc71 100%);
    padding: 100px 0 60px;
    color: #fff;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.about-hero h1 { font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; }
.about-hero p  { font-size: 1.15rem; opacity: .9; max-width: 650px; margin: 0 auto; }

.stats-section { background: #f8fffe; padding: 50px 0; }
.stat-card { text-align: center; padding: 30px 20px; }
.stat-card .stat-number { font-size: 2.5rem; font-weight: 800; color: #1a7a4a; }
.stat-card .stat-label  { color: #555; font-size: .95rem; margin-top: 5px; }

.mvg-section { padding: 60px 0; }
.mvg-card {
    border-radius: 16px;
    padding: 35px 30px;
    height: 100%;
    border-top: 4px solid;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    transition: transform .3s;
}
.mvg-card:hover { transform: translateY(-4px); }
.mvg-card.mission { border-color: #1a7a4a; }
.mvg-card.vision  { border-color: #f39c12; }
.mvg-card.goal    { border-color: #3498db; }
.mvg-card .mvg-icon { font-size: 2.5rem; margin-bottom: 15px; }
.mvg-card h3 { font-size: 1.3rem; font-weight: 700; margin-bottom: 12px; color: #222; }
.mvg-card p  { color: #555; line-height: 1.8; }

.about-content { padding: 60px 0; background: #fff; }
.about-content img { border-radius: 20px; width: 100%; object-fit: cover; max-height: 420px; box-shadow: 0 8px 30px rgba(0,0,0,.1); }
.about-content .about-text { font-size: 1.05rem; line-height: 2; color: #444; }

.work-fields { padding: 60px 0; background: #f8fffe; }
.work-fields .section-title { text-align: center; font-size: 1.8rem; font-weight: 700; color: #1a7a4a; margin-bottom: 40px; }
.field-card {
    background: #fff;
    border-radius: 16px;
    padding: 30px 25px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    transition: transform .3s, box-shadow .3s;
    height: 100%;
}
.field-card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(26,122,74,.15); }
.field-card .field-icon { font-size: 2.8rem; margin-bottom: 15px; }
.field-card h4 { font-weight: 700; color: #222; margin-bottom: 10px; }
.field-card p  { color: #666; font-size: .9rem; line-height: 1.7; }

.about-cta { background: linear-gradient(135deg, #1a7a4a, #27ae60); padding: 60px 0; text-align: center; color: #fff; }
.about-cta h2 { font-size: 2rem; font-weight: 700; margin-bottom: 15px; }
.about-cta p  { opacity: .9; margin-bottom: 30px; }
.btn-cta {
    background: #fff;
    color: #1a7a4a;
    padding: 14px 40px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: all .3s;
    display: inline-block;
}
.btn-cta:hover { background: #f0fff4; color: #1a7a4a; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.2); }

.breadcrumb-section { background: #f0faf5; padding: 12px 0; border-bottom: 1px solid #d4edda; }
.breadcrumb-section a { color: #1a7a4a; text-decoration: none; }
.breadcrumb-section span { color: #888; margin: 0 8px; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb-section">
    <div class="container">
        <small>
            <a href="{{ url($locale.'/') }}">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
            <span>›</span>
            <span class="text-muted">{{ $isAr ? 'من نحن' : 'About Us' }}</span>
        </small>
    </div>
</div>

{{-- Hero --}}
<section class="about-hero">
    @if($about?->hero_image)
    <div style="position:absolute;inset:0;z-index:0;">
        <img src="{{ Storage::url($about->hero_image) }}" alt="" style="width:100%;height:100%;object-fit:cover;opacity:.25;">
    </div>
    <div style="position:relative;z-index:1;">
    @endif
    <div class="container">
        <h1>{{ $isAr ? ($about?->hero_title_ar ?? 'من نحن') : ($about?->hero_title_en ?? 'About Us') }}</h1>
        @if($isAr ? $about?->hero_subtitle_ar : $about?->hero_subtitle_en)
            <p>{{ $isAr ? $about->hero_subtitle_ar : $about->hero_subtitle_en }}</p>
        @endif
    </div>
    @if($about?->hero_image) </div> @endif
</section>

{{-- Stats --}}
@if($about)
<section class="stats-section">
    <div class="container">
        <div class="row">
            @foreach([
                [$about->stat1_number, $isAr ? $about->stat1_label_ar : $about->stat1_label_en],
                [$about->stat2_number, $isAr ? $about->stat2_label_ar : $about->stat2_label_en],
                [$about->stat3_number, $isAr ? $about->stat3_label_ar : $about->stat3_label_en],
                [$about->stat4_number, $isAr ? $about->stat4_label_ar : $about->stat4_label_en],
            ] as [$num, $label])
                @if($num)
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">{{ $num }}</div>
                        <div class="stat-label">{{ $label }}</div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Mission / Vision / Goal --}}
@if($about && ($about->mission_ar || $about->vision_ar || $about->goal_ar))
<section class="mvg-section">
    <div class="container">
        <div class="row g-4">
            @if($isAr ? $about->mission_ar : $about->mission_en)
            <div class="col-md-4">
                <div class="mvg-card mission">
                    <div class="mvg-icon">🎯</div>
                    <h3>{{ $isAr ? 'رسالتنا' : 'Our Mission' }}</h3>
                    <p>{{ $isAr ? $about->mission_ar : $about->mission_en }}</p>
                </div>
            </div>
            @endif
            @if($isAr ? $about->vision_ar : $about->vision_en)
            <div class="col-md-4">
                <div class="mvg-card vision">
                    <div class="mvg-icon">🌟</div>
                    <h3>{{ $isAr ? 'رؤيتنا' : 'Our Vision' }}</h3>
                    <p>{{ $isAr ? $about->vision_ar : $about->vision_en }}</p>
                </div>
            </div>
            @endif
            @if($isAr ? $about->goal_ar : $about->goal_en)
            <div class="col-md-4">
                <div class="mvg-card goal">
                    <div class="mvg-icon">💡</div>
                    <h3>{{ $isAr ? 'هدفنا' : 'Our Goal' }}</h3>
                    <p>{{ $isAr ? $about->goal_ar : $about->goal_en }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- About Text + Image --}}
@if($about && ($about->about_text_ar || $about->about_image))
<section class="about-content">
    <div class="container">
        <div class="row align-items-center g-5 {{ $isAr ? 'flex-row-reverse' : '' }}">
            @if($about->about_image)
            <div class="col-lg-5">
                <img src="{{ Storage::url($about->about_image) }}" alt="{{ $isAr ? 'من نحن' : 'About Us' }}">
            </div>
            @endif
            <div class="col-lg-{{ $about->about_image ? '7' : '12' }}">
                <div class="about-text">
                    {!! $isAr ? $about->about_text_ar : $about->about_text_en !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- Work Fields --}}
@if($workFields->count())
<section class="work-fields">
    <div class="container">
        <h2 class="section-title">{{ $isAr ? 'مجالات عملنا' : 'Our Work Areas' }}</h2>
        <div class="row g-4">
            @foreach($workFields as $field)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="field-card">
                    @if($field->icon)
                        <div class="field-icon">{{ $field->icon }}</div>
                    @endif
                    <h4>{{ $isAr ? $field->title_ar : $field->title_en }}</h4>
                    @if($isAr ? $field->description_ar : $field->description_en)
                        <p>{{ $isAr ? $field->description_ar : $field->description_en }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="about-cta">
    <div class="container">
        <h2>{{ $isAr ? 'انضم إلينا اليوم' : 'Join Us Today' }}</h2>
        <p>{{ $isAr ? 'ساهم معنا في صنع فارق حقيقي في حياة المحتاجين' : 'Help us make a real difference in the lives of those in need' }}</p>
        @if($about?->cta_url)
        <a href="{{ $about->cta_url }}" class="btn-cta">
            {{ $isAr ? ($about->cta_text_ar ?? 'تبرع الآن') : ($about->cta_text_en ?? 'Donate Now') }}
        </a>
        @else
        <a href="{{ url($locale.'/campaigns') }}" class="btn-cta">
            {{ $isAr ? 'تبرع الآن' : 'Donate Now' }}
        </a>
        @endif
    </div>
</section>

@endsection
