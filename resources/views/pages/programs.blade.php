@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'البرامج الإنسانية':'Humanitarian Programs') . ' | مؤسسة رؤيا الإنسانية')
@section('description', $locale==='ar'?'اكتشف البرامج الإنسانية الشاملة لمؤسسة رؤيا الإنسانية.':'Discover the comprehensive humanitarian programs of Roaya Insanya.')

@section('content')

<section class="page-hero-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url($locale) }}">{{ $locale==='ar'?'الرئيسية':'Home' }}</a></li>
                <li class="breadcrumb-item active">{{ $locale==='ar'?'البرامج':'Programs' }}</li>
            </ol>
        </nav>
        <h1 class="section-title">{{ $locale==='ar'?'البرامج الإنسانية':'Humanitarian Programs' }}</h1>
        <p class="muted-color mt-2">{{ $locale==='ar'?'برامج شاملة مصممة لتوفير الدعم المستدام وإحداث تأثير دائم.':'Comprehensive programs designed to provide sustainable support and lasting impact.' }}</p>
    </div>
</section>

<section class="main-section">
    <div class="container">

        {{-- Category Filter --}}
        @php
        $categories = [
            ['key'=>'all',         'label'=>$locale==='ar'?'الكل':'All'],
            ['key'=>'education',   'label'=>$locale==='ar'?'التعليم':'Education'],
            ['key'=>'health',      'label'=>$locale==='ar'?'الصحة الطارئة':'Emergency Health'],
            ['key'=>'cash',        'label'=>$locale==='ar'?'الدعم النقدي':'Cash Support'],
            ['key'=>'shelter',     'label'=>$locale==='ar'?'المأوى والحماية':'Shelter & Protection'],
            ['key'=>'water',       'label'=>$locale==='ar'?'المياه والصرف الصحي':'Water & Sanitation'],
            ['key'=>'psychosocial','label'=>$locale==='ar'?'الدعم النفسي':'Psychosocial Support'],
        ];
        $activeCategory = request('category', 'all');
        @endphp

        <div class="category-filter mb-5">
            @foreach($categories as $cat)
            <a href="{{ url($locale.'/programs?category='.$cat['key']) }}"
               class="category-btn {{ $activeCategory==$cat['key']?'active':'' }}">
                {{ $cat['label'] }}
            </a>
            @endforeach
        </div>

        {{-- Programs Grid --}}
        @if(!empty($programs) && !empty($programs['data']))
        <div class="row g-4">
            @foreach($programs['data'] as $prog)
            @php
                $pImg    = $prog['image'] ?? $prog['thumbnail'] ?? 'https://roaya-ansany.com/website/images/stats-card.png';
                $pTitle  = $prog['title'] ?? $prog['name'] ?? '';
                $pDesc   = $prog['description'] ?? '';
                $pSlug   = $prog['slug'] ?? $prog['id'] ?? '';
                $pDate   = isset($prog['created_at']) ? \Carbon\Carbon::parse($prog['created_at'])->format('d-m-Y') : '';
                $pCat    = $prog['category'] ?? $prog['type'] ?? '';
                $pGoal   = $prog['goal_amount'] ?? 0;
                $pRaised = $prog['raised_amount'] ?? 0;
                $pPct    = $pGoal > 0 ? min(100, round(($pRaised / $pGoal) * 100)) : 0;
            @endphp
            <div class="col-lg-4 col-md-6">
                <div class="program-card h-100">
                    <div class="program-img-wrap">
                        <img src="{{ $pImg }}" alt="{{ $pTitle }}" class="program-img">
                        @if($pCat)<span class="program-badge">{{ $pCat }}</span>@endif
                        @if($pDate)<span class="program-date-badge">{{ $pDate }}</span>@endif
                    </div>
                    <div class="program-body">
                        <h5 class="program-title">{{ $pTitle }}</h5>
                        @if($pDesc)<p class="program-desc">{{ Str::limit(strip_tags($pDesc), 100) }}</p>@endif
                        @if($pGoal > 0)
                        <div class="progress-container mb-2">
                            <div class="progress-bar"><div class="progress-fill" style="width:{{ $pPct }}%"></div></div>
                        </div>
                        <div class="d-flex justify-content-between mb-3" style="font-size:12px;color:#888">
                            <span>{{ $locale==='ar'?'تم جمعه':'Raised' }}: ${{ number_format($pRaised) }}</span>
                            <span class="fw-bold main-color">{{ $pPct }}%</span>
                            <span>{{ $locale==='ar'?'الهدف':'Goal' }}: ${{ number_format($pGoal) }}</span>
                        </div>
                        @endif
                        <a href="{{ url($locale.'/campaigns/'.$pSlug) }}" class="btn-donate w-100 text-center d-block">
                            {{ $locale==='ar'?'تبرع الآن':'Donate Now' }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if(!empty($programs['meta']) && $programs['meta']['last_page'] > 1)
        <div class="d-flex justify-content-center align-items-center mt-5 gap-3">
            @if($programs['meta']['current_page'] > 1)
            <a href="{{ url($locale.'/programs?page='.($programs['meta']['current_page']-1)) }}" class="btn-outline">
                {{ $locale==='ar'?'السابق':'Previous' }}
            </a>
            @endif
            <span class="muted-color">
                {{ $locale==='ar'?'صفحة':'Page' }} {{ $programs['meta']['current_page'] }} {{ $locale==='ar'?'من':'of' }} {{ $programs['meta']['last_page'] }}
            </span>
            @if($programs['meta']['current_page'] < $programs['meta']['last_page'])
            <a href="{{ url($locale.'/programs?page='.($programs['meta']['current_page']+1)) }}" class="btn-donate">
                {{ $locale==='ar'?'التالي':'Next' }}
            </a>
            @endif
        </div>
        @endif

        @else
        <div class="text-center py-5">
            <i class="fa-solid fa-folder-open fa-4x main-color mb-4"></i>
            <h4>{{ $locale==='ar'?'لا توجد برامج حاليًا':'No programs available yet' }}</h4>
        </div>
        @endif
    </div>
</section>

@push('styles')
<style>
.page-hero-section { background:linear-gradient(135deg,#f8fdf4,#eef7e6); padding:60px 0 40px; }
.page-hero-section .breadcrumb-item a { color:#5a9e2f; text-decoration:none; }
.category-filter { display:flex; flex-wrap:wrap; gap:10px; }
.category-btn { padding:8px 20px; border-radius:50px; background:#f0f9e8; color:#5a9e2f; font-size:14px; font-weight:600; text-decoration:none; border:2px solid transparent; transition:all 0.3s; }
.category-btn:hover, .category-btn.active { background:#5a9e2f; color:white; }
.program-card { background:white; border-radius:16px; overflow:hidden; border:1px solid #e8f4d9; transition:all 0.3s; }
.program-card:hover { box-shadow:0 8px 32px rgba(90,158,47,0.15); transform:translateY(-4px); }
.program-img-wrap { position:relative; overflow:hidden; height:210px; }
.program-img { width:100%; height:100%; object-fit:cover; transition:transform 0.4s; }
.program-card:hover .program-img { transform:scale(1.05); }
.program-badge { position:absolute; top:12px; inset-inline-start:12px; background:#5a9e2f; color:white; font-size:11px; padding:4px 10px; border-radius:20px; }
.program-date-badge { position:absolute; bottom:12px; inset-inline-end:12px; background:rgba(0,0,0,0.5); color:white; font-size:11px; padding:3px 8px; border-radius:6px; }
.program-body { padding:20px; }
.program-title { font-size:15px; font-weight:700; color:#333; line-height:1.5; margin-bottom:8px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.program-desc { font-size:13px; color:#777; line-height:1.6; margin-bottom:12px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
</style>
@endpush
@endsection
