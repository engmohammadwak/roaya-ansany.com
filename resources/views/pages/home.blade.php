@extends('layouts.app')

@php
    $locale = app()->getLocale();
    $p = App\Models\Setting::get('color_primary', '#9dcc6b');

    $hero      = $data['hero'] ?? [];
    $heroTitle = $hero['title']       ?? ($locale==='ar' ? 'أنقذوا غزة الآن' : 'Save Gaza Now');
    $heroDesc  = $hero['description'] ?? ($locale==='ar' ? 'ملايين المدنيين يواجهون الجوع والتشرد.' : 'Millions face hunger and displacement.');
    $heroImg   = $hero['image']       ?? 'https://roaya-ansany.com/storage/uploads/pages/3PCwY0bnxr9NmLyHvTlL7wlNmBC5ir5vBG5gv0Wz.png';

    // يقرأ من الداشبورد فقط
    $heroLabel = $locale === 'ar'
        ? App\Models\Setting::get('hero_label_ar', '')
        : App\Models\Setting::get('hero_label_en', '');
@endphp

@section('title', $locale === 'ar' ? 'الرئيسية' : 'Home')
@section('description', $locale === 'ar' ? 'ساهم في إنقاذ الأرواح ودعم المحتاجين عبر حملاتنا.' : 'Help save lives through our campaigns.')

@section('content')

{{-- ============ HERO SLIDER ============ --}}
@php $sliderProjects = array_slice($projects['data'] ?? [], 0, 5); @endphp
@if(!empty($sliderProjects))
<section class="hero-slider-section" style="position:relative">

    @if($heroLabel)
    <div style="position:absolute;
                top:12px;
                left:351px;
                right:0;
                text-align:center;
                z-index:2;
                font-size:14px;
                color:#555;
                font-weight:500;
                pointer-events:none;">
        {{ $heroLabel }}
    </div>
    @endif

    <div class="hero-swiper swiper">
        <div class="swiper-wrapper">
            @foreach($sliderProjects as $slide)
            @php
                $slideGoal   = $slide['goal_amount'] ?? 0;
                $slideRaised = $slide['raised_amount'] ?? 0;
                $slidePct    = $slideGoal > 0 ? min(100, round(($slideRaised / $slideGoal) * 100)) : 0;
                $slideImg    = $slide['image'] ?? $slide['thumbnail'] ?? 'https://roaya-ansany.com/website/images/stats-card.png';
                $slideTitle  = $slide['title'] ?? $slide['name'] ?? '';
                $slideSlug   = $slide['slug'] ?? $slide['id'] ?? '';
            @endphp
            <div class="swiper-slide">
                <div class="hero-slide" style="background-image:url('{{ $slideImg }}')">
                    <div class="hero-slide-overlay"></div>
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-lg-7">
                                <div class="hero-slide-content">
                                    <h2 class="hero-slide-title">{{ $slideTitle }}</h2>
                                    <div class="slide-progress mt-3 mb-2">
                                        <div class="slide-progress-bar">
                                            <div class="slide-progress-fill" style="width:{{ $slidePct }}%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2 text-white" style="font-size:13px">
                                            <span>{{ $locale==='ar'?'تم جمعه':'Raised' }}: ${{ number_format($slideRaised) }}</span>
                                            <span>{{ $slidePct }}%</span>
                                            <span>{{ $locale==='ar'?'الهدف':'Goal' }}: ${{ number_format($slideGoal) }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ url($locale.'/campaigns/'.$slideSlug) }}" class="btn-donate mt-3 d-inline-block">
                                        {{ $locale==='ar'?'تبرع الآن':'Donate Now' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination hero-pagination"></div>
        <div class="swiper-button-next hero-next"></div>
        <div class="swiper-button-prev hero-prev"></div>
    </div>
</section>
@else
{{-- ============ HERO BANNER (fallback) ============ --}}
<section class="hero-banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-sm-12">
                <h1 class="main-title">{!! $heroTitle !!}</h1>
                <p class="main-p my-3 my-lg-5">{{ $heroDesc }}</p>
                <form action="#">
                    <div class="row">
                        <div class="col-lg-9 col-8">
                            <input type="text" name="amount" class="form-input w-100" placeholder="{{ $locale==='ar'?'ادخل المبلغ':'Enter amount' }}">
                        </div>
                        <div class="col-lg-3 col-4">
                            <button type="submit" class="btn-donate w-100">{{ $locale==='ar'?'تبرع الآن':'Donate Now' }}</button>
                        </div>
                        <div class="col-md-12">
                            <div class="progress-container mt-4">
                                <div class="progress-bar"><div style="width:100%" class="progress-fill"></div></div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="banner-footer mt-4">
                    <div class="d-flex align-items-center">
                        <img width="27" height="27" class="me-3" src="https://roaya-ansany.com/website/images/verified.svg" alt="verified">
                        <p class="muted-color">{{ $locale==='ar'?'تبرعاتكم تُدار بشفافية كاملة وتصل مباشرةً إلى المستفيدين.':'Donations managed with full transparency and reach beneficiaries directly.' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="clipped-image-container" style="position:relative">
                    <svg viewBox="0 0 441 388" preserveAspectRatio="none" style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:0">
                        <path d="M43 0C19.2518 0 0 19.2518 0 43V345C0 368.748 19.2518 388 43 388H398C421.748 388 441 368.748 441 345V115C441 98.9837 428.016 86 412 86H329C312.984 86 300 73.0163 300 57V29C300 12.9837 287.016 0 271 0H43Z" fill="{{ $p }}" fill-opacity="0.15"/>
                    </svg>
                    @if($heroLabel)
                    <div style="position:absolute;
                                top:12px;
                                left:351px;
                                right:0;
                                text-align:center;
                                z-index:2;
                                font-size:14px;
                                color:#555;
                                font-weight:500;">
                        {{ $heroLabel }}
                    </div>
                    @endif
                    <img width="510" height="430" src="{{ $heroImg }}" alt="banner" style="position:relative;z-index:1;width:100%;border-radius:20px">
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ============ CAMPAIGN BANNER ============ --}}
@php
    $cb         = $data['campaign_banner'] ?? [];
    $cbImg      = $cb['image']       ?? 'https://roaya-ansany.com/storage/uploads/pages/94VHn4ZdEJ3QxaD8xMoObV8IGHOyvRDM9jqXGtKV.jpg';
    $cbTitle    = $cb['title']       ?? ($locale==='ar' ? 'رابطة علماء فلسطين تُشيد بمؤسستنا' : 'Palestine Scholars praise us');
    $cbSubtitle = $cb['subtitle']    ?? ($locale==='ar' ? 'تؤكد الالتزام بالشفافية والضوابط الشرعية' : 'Confirms commitment to transparency and Sharia standards');
    $cbDesc     = $cb['description'] ?? ($locale==='ar' ? 'أصدرت رابطة علماء فلسطين بيانًا رسميًا أكدت فيه التزامنا.' : 'The Palestine Scholars Association issued an official statement.');
@endphp
<section class="main-section">
    <div class="container">
        <div class="campaign-banner">
            <div class="row align-items-center">
                <div class="col-md-5 order-2 order-lg-1">
                    <img src="{{ $cbImg }}" class="img-fluid rounded-3" alt="campaign">
                </div>
                <div class="col-md-7 order-1 order-lg-2 ps-lg-5">
                    <h2 class="section-title mt-4 text-start">{{ $cbTitle }}</h2>
                    <h6 class="main-color mt-2 mb-3 text-start" style="font-size:15px;font-weight:600">{{ $cbSubtitle }}</h6>
                    <p class="color-67 text-start" style="font-size:14px;line-height:1.9">{{ $cbDesc }}</p>
                    <form action="#" class="mt-4">
                        <div class="row">
                            <div class="col-9"><input type="text" name="amount" class="form-input gray w-100" placeholder="{{ $locale==='ar'?'ادخل المبلغ':'Enter amount' }}"></div>
                            <div class="col-3"><button type="submit" class="btn-donate w-100">{{ $locale==='ar'?'تبرع الآن':'Donate Now' }}</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ CAMPAIGNS ============ --}}
@php $homeProjects = array_slice($projects['data'] ?? [], 0, 6); @endphp
@if(!empty($homeProjects))
<section class="main-section">
    <div class="container">
        <div class="header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6>{{ $locale==='ar'?'حملاتنا':'Our Campaigns' }}</h6>
                <h2 class="section-title">{{ $locale==='ar'?'أحدث حملات التبرع':'Latest Donation Campaigns' }}</h2>
            </div>
            <a href="{{ url($locale.'/campaigns') }}" class="btn-outline">{{ $locale==='ar'?'عرض الكل':'View All' }}</a>
        </div>
        <div class="row">
            @foreach($homeProjects as $proj)
            @php
                $pGoal   = $proj['goal_amount'] ?? 0;
                $pRaised = $proj['raised_amount'] ?? 0;
                $pPct    = $pGoal > 0 ? min(100, round(($pRaised / $pGoal) * 100)) : 0;
                $pImg    = $proj['image'] ?? $proj['thumbnail'] ?? 'https://roaya-ansany.com/website/images/stats-card.png';
                $pTitle  = $proj['title'] ?? $proj['name'] ?? '';
                $pSlug   = $proj['slug'] ?? $proj['id'] ?? '';
            @endphp
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="campaign-card h-100">
                    <img src="{{ $pImg }}" class="img-fluid w-100" alt="{{ $pTitle }}" style="height:200px;object-fit:cover;border-radius:12px 12px 0 0">
                    <div class="campaign-card-body p-3">
                        <h5 class="campaign-card-title mb-3">{{ $pTitle }}</h5>
                        <div class="progress-container mb-2"><div class="progress-bar"><div class="progress-fill" style="width:{{ $pPct }}%"></div></div></div>
                        <div class="d-flex justify-content-between text-muted mb-3" style="font-size:13px">
                            <div class="text-center"><div class="fw-bold main-color">${{ number_format($pRaised) }}</div><div>{{ $locale==='ar'?'تم جمعه':'Raised' }}</div></div>
                            <div class="text-center"><div class="fw-bold">{{ $pPct }}%</div><div>{{ $locale==='ar'?'مكتمل':'Complete' }}</div></div>
                            <div class="text-center"><div class="fw-bold">${{ number_format($pGoal) }}</div><div>{{ $locale==='ar'?'الهدف':'Goal' }}</div></div>
                        </div>
                        <a href="{{ url($locale.'/campaigns/'.$pSlug) }}" class="btn-donate w-100 text-center d-block">{{ $locale==='ar'?'تبرع الآن':'Donate Now' }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ WHY DONATE ============ --}}
@php
    $whyCards = $data['why_donate'] ?? [];
    $defaultCards = [
        ['icon'=>'fa-house-crack',   'title'=>($locale==='ar'?'الأطفال والنساء بلا مأوى':'Children & Women Without Shelter'),      'description'=>($locale==='ar'?'نهتم بالأطفال والنساء الذين هُدمت منازلهم ويعيشون في الخيام ومراكز الإيواء.':'We care for children and women whose homes were destroyed.')],
        ['icon'=>'fa-bowl-food',     'title'=>($locale==='ar'?'الأطفال والنساء بلا غذاء':'Children & Women Without Food'),         'description'=>($locale==='ar'?'نقدّم الدعم للأسر التي تعاني من شبح المجاعة.':'We support families suffering from famine.')],
        ['icon'=>'fa-people-arrows', 'title'=>($locale==='ar'?'الأسر النازحة':'Displaced Families'),                       'description'=>($locale==='ar'?'نهتم بالأسر التي نزحت إلى مراكز الإيواء.':'We care for families displaced to shelters.')],
        ['icon'=>'fa-box-open',      'title'=>($locale==='ar'?'توزيع الطرود الغذائية':'Food Package Distribution'),              'description'=>($locale==='ar'?'نسعى إلى توفير طرود غذائية للأسر الفقيرة.':'We provide food packages for poor families.')],
        ['icon'=>'fa-child-reaching','title'=>($locale==='ar'?'كفالة الأيتام والأرامل':'Orphan & Widow Sponsorship'),            'description'=>($locale==='ar'?'نساند الأيتام والنساء الأرامل.':'We support orphans and widows.')],
        ['icon'=>'fa-droplet',       'title'=>($locale==='ar'?'مشاريع سقيا الماء':'Water Projects'),                              'description'=>($locale==='ar'?'ندعم حفر الآبار وتوفير المياه.':'We support well drilling and water provision.')],
    ];
    if (empty($whyCards)) $whyCards = $defaultCards;
@endphp
<section class="main-section why-donate">
    <div class="container">
        <div class="header text-end" dir="rtl">
            <h6>{{ $locale==='ar'?'لماذا تتبرع لنا؟':'Why donate to us?' }}</h6>
            <h2 class="section-title">{{ $locale==='ar'?'لأننا نهتم بالحالات الأكثر احتياجًا.':'Because we care about those in greatest need.' }}</h2>
        </div>
        <div class="row mt-5">
            @foreach($whyCards as $card)
            @php $icon = $card['icon'] ?? 'fa-heart'; @endphp
            <div class="col-lg-4 mb-4">
                <div class="why-donate-card">
                    <div class="why-icon-wrap mb-3">
                        <div class="why-icon-circle"><i class="fa-solid {{ $icon }} fa-lg"></i></div>
                    </div>
                    <h5 class="mb-3">{{ $card['title'] ?? '' }}</h5>
                    <p class="mb-4">{{ $card['description'] ?? '' }}</p>
                    <div class="d-flex justify-content-between mt-3">
                        <input type="text" name="amount" class="form-input" placeholder="{{ $locale==='ar'?'ادخل المبلغ':'Enter amount' }}">
                        <button type="button" class="btn-donate">{{ $locale==='ar'?'تبرع':'Donate' }}</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ PROGRAMS ============ --}}
@if(!empty($programs) && !empty($programs['data']))
<section class="main-section">
    <div class="container">
        <div class="header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6>{{ $locale==='ar'?'برامجنا':'Our Programs' }}</h6>
                <h2 class="section-title">{{ $locale==='ar'?'البرامج الإنسانية':'Humanitarian Programs' }}</h2>
            </div>
            <a href="{{ url($locale.'/campaigns') }}" class="btn-outline">{{ $locale==='ar'?'عرض الكل':'View All' }}</a>
        </div>
        <div class="row">
            @foreach(array_slice($programs['data'], 0, 3) as $program)
            @php
                $pgImg    = $program['image'] ?? 'https://roaya-ansany.com/website/images/stats-card.png';
                $pgTitle  = $program['title'] ?? $program['name'] ?? '';
                $pgDesc   = $program['description'] ?? '';
                $pgSlug   = $program['slug'] ?? $program['id'] ?? '';
                $pgGoal   = $program['goal_amount'] ?? 0;
                $pgRaised = $program['raised_amount'] ?? 0;
                $pgPct    = $pgGoal > 0 ? min(100, round(($pgRaised / $pgGoal) * 100)) : 0;
            @endphp
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="program-card h-100">
                    <img src="{{ $pgImg }}" class="img-fluid w-100" alt="{{ $pgTitle }}" style="height:220px;object-fit:cover;border-radius:12px 12px 0 0">
                    <div class="p-4">
                        <h5 class="mb-2">{{ $pgTitle }}</h5>
                        @if($pgDesc)<p class="color-67 mb-3" style="font-size:14px">{{ Str::limit(strip_tags($pgDesc), 100) }}</p>@endif
                        @if($pgGoal > 0)
                        <div class="progress-container mb-2"><div class="progress-bar"><div class="progress-fill" style="width:{{ $pgPct }}%"></div></div></div>
                        <div class="d-flex justify-content-between text-muted mb-3" style="font-size:13px">
                            <span>{{ $locale==='ar'?'تم جمعه':'Raised' }}: ${{ number_format($pgRaised) }}</span>
                            <span>{{ $pgPct }}%</span>
                            <span>{{ $locale==='ar'?'الهدف':'Goal' }}: ${{ number_format($pgGoal) }}</span>
                        </div>
                        @endif
                        <a href="{{ url($locale.'/campaigns/'.$pgSlug) }}" class="btn-donate w-100 text-center d-block">{{ $locale==='ar'?'تبرع الآن':'Donate Now' }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============ WHERE WE WORK ============ --}}
@php
    $about      = $data['about'] ?? [];
    $aboutTitle = $about['title']       ?? ($locale==='ar'?'من نحن':'About Us');
    $aboutDesc  = $about['description'] ?? ($locale==='ar'?'مؤسسة أهلية غير ربحية.':'Non-profit organization.');
    $aboutImg   = $about['image']       ?? 'https://roaya-ansany.com/storage/uploads/pages/dWfpjiaOmZUcA0BC2wvyPZotctgE6L3TwskmdcsO.jpg';
@endphp
<section class="main-section where-work">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="where-card">
                    <h2 class="section-title mb-4">{{ $aboutTitle }}</h2>
                    <p class="muted-color mb-3">{{ $aboutDesc }}</p>
                    <form action="">
                        <input type="text" name="amount" class="form-input w-100 mt-4" placeholder="{{ $locale==='ar'?'ادخل المبلغ':'Enter amount' }}">
                        <div class="progress-container mt-4"><div class="progress-bar"><div style="width:100%" class="progress-fill"></div></div></div>
                        <a href="{{ url($locale.'/donate') }}" class="btn-donate text-center mt-3 d-block">{{ $locale==='ar'?'تبرع':'Donate' }}</a>
                    </form>
                </div>
            </div>
            <div class="col-md-6"><div class="why-imgs"><img src="{{ $aboutImg }}" class="img-fluid" alt="about"></div></div>
        </div>
    </div>
</section>

{{-- ============ STATS CARD ============ --}}
@php
    $statsImg   = $data['stats_image'] ?? 'https://roaya-ansany.com/website/images/stats-card.png';
    $statsTitle = $data['stats_title'] ?? ($locale==='ar'?'الإغاثة العاجلة لأهل غزة، لبنان، شمال سوريا، السودان ودعم المحتاجين في تركيا':'Emergency relief for Gaza, Lebanon, North Syria, Sudan and Turkey');
    $totalGoal   = collect($projects['data'] ?? [])->sum('goal_amount');
    $totalRaised = collect($projects['data'] ?? [])->sum('raised_amount');
    $totalRemain = max(0, $totalGoal - $totalRaised);
@endphp
<section class="main-section">
    <div class="container">
        <div class="stats-card">
            <img src="{{ $statsImg }}" class="img-fluid" alt="kids">
            <div class="text-center pt-5">
                <p class="text-white">{{ $locale==='ar'?'مشاريعنا تقدم لـ':'Our projects offer' }}</p>
                <h2 class="text-white mt-4 section-title">{{ $statsTitle }}</h2>
            </div>
            <div class="stats mt-5">
                <div class="row">
                    <div class="col-md-4"><div class="stat w-100 mb-3"><span>{{ $locale==='ar'?'المتبقي':'Remaining' }}</span><span>${{ number_format($totalRemain) }}</span></div></div>
                    <div class="col-md-4"><div class="stat w-100 mb-3"><span>{{ $locale==='ar'?'المبلغ المُجمَّع':'Raised' }}</span><span>${{ number_format($totalRaised) }}</span></div></div>
                    <div class="col-md-4"><div class="stat w-100 mb-3"><span>{{ $locale==='ar'?'الهدف':'Goal' }}</span><span>${{ number_format($totalGoal) }}</span></div></div>
                </div>
            </div>
            <div class="text-center my-5">
                <a href="{{ url($locale.'/donate') }}" class="btn-donate mx-auto bg-white">{{ $locale==='ar'?'تبرع الآن':'Donate Now' }}</a>
            </div>
        </div>
    </div>
</section>

{{-- ============ DONATION COUNTER ============ --}}
@include('partials.donation-counter', ['donationCounter' => $data['donation_counter'] ?? []])

{{-- ============ SUPPORT ============ --}}
@php
    $support      = $data['support'] ?? [];
    $supportImg   = $support['image'] ?? 'https://roaya-ansany.com/storage/uploads/pages/JDqjlXwu5odPJit3bTMC8NQxssv8OKDDNyPeVwPS.jpg';
    $supportItems = $support['items'] ?? [
        ($locale==='ar'?'مشاريع إغاثة المياه':'Water relief projects'),
        ($locale==='ar'?'برامج كفالة الأيتام':'Orphan sponsorship programs'),
        ($locale==='ar'?'توفير طرود غذائية ووجبات':'Food packages and meals'),
        ($locale==='ar'?'تجديد مراكز الإيواء':'Shelter renovation'),
        ($locale==='ar'?'تقديم مساعدات نقدية':'Cash assistance'),
    ];
@endphp
<section class="main-section">
    <div class="container">
        <div class="support">
            <div class="row">
                <div class="col-md-5 mb-5"><img class="w-lg-100 img-fluid" src="{{ $supportImg }}" alt="support"></div>
                <div class="col-md-7">
                    <div class="content">
                        <h2 class="section-title mb-4">{{ $locale==='ar'?'من نحن':'About Us' }}</h2>
                        <p class="muted-color">{{ $locale==='ar'?'مؤسسة خيرية غير ربحية تعمل في المجال الإنساني.':'A non-profit organization in the humanitarian field.' }}</p>
                        <div class="container my-5 text-end" dir="rtl">
                            <div class="row g-3 justify-content-center">
                                <div class="col-12 col-md-6">
                                    <ul class="numbered-list list-unstyled m-0">
                                        @foreach(array_slice($supportItems, 0, 3) as $i => $item)
                                        <li><span>{{ $i+1 }}</span><p>{{ is_array($item) ? ($item['title'] ?? '') : $item }}</p></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-12 col-md-6">
                                    <ul class="numbered-list list-unstyled m-0">
                                        @foreach(array_slice($supportItems, 3) as $i => $item)
                                        <li><span>{{ $i+4 }}</span><p>{{ is_array($item) ? ($item['title'] ?? '') : $item }}</p></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ PARTNERS ============ --}}
@php
    $partners = $data['partners'] ?? [];
    $defaultPartners = [
        ['name'=>($locale==='ar'?'هيئة الزكاة الفلسطينية':'Palestinian Zakat Authority'), 'icon'=>'fa-hand-holding-dollar','color'=>'#e8f4fd'],
        ['name'=>($locale==='ar'?'معهد الأمل للأيتام':'Al-Amal Institute for Orphans'),  'icon'=>'fa-children',           'color'=>'#edf7ee'],
        ['name'=>($locale==='ar'?'وزارة التنمية الاجتماعية':'Ministry of Social Development'),'icon'=>'fa-building-columns','color'=>'#fdf3e7'],
    ];
    if (empty($partners)) $partners = $defaultPartners;
@endphp
<section class="main-section">
    <div class="container">
        <p class="color-67 text-center"><i class="fa-solid fa-handshake main-color me-2"></i>{{ $locale==='ar'?'الشركاء':'Partners' }}</p>
        <h2 class="text-center section-title mx-auto my-3">{{ $locale==='ar'?'موثوق بها من جهات إنسانية وخيرية':'Trusted by humanitarian organizations' }}</h2>
        <p class="color-67 text-center mb-5">{{ $locale==='ar'?'هل ستنقذ روحًا؟':'Will you save a soul?' }} <a href="{{ url($locale.'/donate') }}" class="main-color fw-bold">{{ $locale==='ar'?'تبرع الآن':'Donate Now' }}</a></p>
        <div class="row justify-content-center g-4">
            @foreach($partners as $partner)
            @php
                $pName  = $partner['name']  ?? '';
                $pIcon  = $partner['icon']  ?? 'fa-handshake';
                $pColor = $partner['color'] ?? '#f0f7ff';
                $pImg   = $partner['image'] ?? $partner['logo'] ?? null;
            @endphp
            <div class="col-lg-3 col-md-4 col-6">
                <div class="partner-card text-center p-4" style="background:{{ $pColor }};border-radius:16px;border:1px solid rgba(0,0,0,0.06)">
                    @if($pImg)
                    <img src="{{ $pImg }}" alt="{{ $pName }}" class="img-fluid mb-3" style="max-height:70px;object-fit:contain">
                    @else
                    <div style="width:60px;height:60px;border-radius:50%;background:white;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;box-shadow:0 2px 8px rgba(0,0,0,0.1)">
                        <i class="fa-solid {{ $pIcon }} fa-lg main-color"></i>
                    </div>
                    @endif
                    <h6 class="mb-0" style="font-size:14px;font-weight:600">{{ $pName }}</h6>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ FAQ ============ --}}
@php
    $faqs = $data['faqs'] ?? [];
    $defaultFaqs = [
        ['question'=>($locale==='ar'?'كيف يمكنني التبرع؟':'How can I donate?'), 'answer'=>($locale==='ar'?'عبر الموقع مباشرةً باختيار المشروع وإدخال المبلغ.':'Through the website by selecting a project and entering the amount.')],
        ['question'=>($locale==='ar'?'هل تبرعاتي تصل؟':'Do my donations reach?'), 'answer'=>($locale==='ar'?'نعم، 100% تصل للمستحقين عبر شركاء موثوقين.':'Yes, 100% reaches beneficiaries through trusted partners.')],
        ['question'=>($locale==='ar'?'هل يمكنني متابعة مشروعي؟':'Can I follow my project?'), 'answer'=>($locale==='ar'?'نعم، تقارير دورية وصور ميدانية لكل مشروع.':'Yes, periodic reports and field photos for each project.')],
        ['question'=>($locale==='ar'?'ما هي مشاريعكم؟':'What are your projects?'), 'answer'=>($locale==='ar'?'كفالة الأيتام، طرود غذائية، حفر آبار، بناء مساجد، دعم مرضى.':'Orphan sponsorship, food packages, well drilling, mosque construction.')],
        ['question'=>($locale==='ar'?'كيف أتواصل معكم؟':'How to contact you?'), 'answer'=>($locale==='ar'?'عبر صفحة اتصل بنا أو حساباتنا على التواصل الاجتماعي.':'Through the Contact Us page or our social media accounts.')],
    ];
    if (empty($faqs)) $faqs = $defaultFaqs;
@endphp
<section class="main-section faq-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <h6>{{ $locale==='ar'?'الأسئلة الشائعة':'FAQ' }}</h6>
                <h2 class="section-title mb-4">{{ $locale==='ar'?'أسئلة وأجوبة حول التبرع':'Q&A About Donating' }}</h2>
                <p class="muted-color mb-4">{{ $locale==='ar'?'إذا لم تجد إجابتك، تواصل معنا.':'If you don\'t find your answer, contact us.' }}</p>
                <a href="{{ url($locale.'/contact') }}" class="btn-donate d-inline-block">{{ $locale==='ar'?'تواصل معنا':'Contact Us' }}</a>
            </div>
            <div class="col-lg-7">
                <div class="accordion faq-accordion" id="faqAccordion">
                    @foreach($faqs as $fi => $faq)
                    <div class="accordion-item faq-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $fi>0?'collapsed':'' }} faq-btn" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faqC{{ $fi }}" aria-expanded="{{ $fi===0?'true':'false' }}">
                                {{ $faq['question'] ?? '' }}
                            </button>
                        </h2>
                        <div id="faqC{{ $fi }}" class="accordion-collapse collapse {{ $fi===0?'show':'' }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body faq-body">{{ $faq['answer'] ?? '' }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ NEWSLETTER ============ --}}
@php
    $nlTitle = $data['newsletter_title'] ?? ($locale==='ar'?'اشترك في نشرتنا البريدية':'Subscribe to Our Newsletter');
    $nlDesc  = $data['newsletter_description'] ?? ($locale==='ar'?'احصل على آخر أخبار المشاريع مباشرةً في بريدك.':'Get the latest project news directly in your inbox.');
@endphp
<section class="main-section newsletter-section">
    <div class="container">
        <div class="newsletter-box text-center">
            <h6>{{ $locale==='ar'?'ابقَ على اطلاع':'Stay Updated' }}</h6>
            <h2 class="section-title mb-3">{{ $nlTitle }}</h2>
            <p class="muted-color mb-4">{{ $nlDesc }}</p>
            <form action="#" method="POST" class="d-flex justify-content-center gap-3 flex-wrap">
                @csrf
                <input type="email" name="email" class="form-input" style="max-width:380px;flex:1"
                    placeholder="{{ $locale==='ar'?'أدخل بريدك الإلكتروني':'Enter your email' }}" required>
                <button type="submit" class="btn-donate">{{ $locale==='ar'?'اشترك الآن':'Subscribe Now' }}</button>
            </form>
        </div>
    </div>
</section>

{{-- ============ CTA ============ --}}
<section class="main-section">
    <div class="container">
        <div class="donate overflow-hidden">
            <div class="content">
                <h2 class="main-title text-white mb-4">{{ $locale==='ar'?'تبرّع الآن — أنقذ حياة':'Donate Now — Save Lives' }}</h2>
                <p>{{ $locale==='ar'?'تبرّعك، مهما كان صغيرًا، يصنع تأثيرًا دائمًا.':'Your contribution, no matter how small, makes a lasting impact.' }}</p>
                <div class="mt-4 holder">
                    <input type="text" name="amount" class="form-input" placeholder="{{ $locale==='ar'?'ادخل المبلغ':'Enter amount' }}">
                    <button type="button" class="btn-donate">{{ $locale==='ar'?'تبرع':'Donate' }}</button>
                </div>
            </div>
            <img src="https://roaya-ansany.com/website/images/donate-child.svg" class="d-none d-lg-block" alt="donate">
        </div>
    </div>
</section>

@push('styles')
<style>
.why-icon-circle {
    width:64px; height:64px; border-radius:50%;
    background: linear-gradient(135deg, color-mix(in srgb, {{ $p }} 15%, transparent), color-mix(in srgb, {{ $p }} 5%, transparent));
    display:flex; align-items:center; justify-content:center;
    margin:0 auto;
    border: 2px solid color-mix(in srgb, {{ $p }} 30%, transparent);
}
.why-icon-circle i { color: color-mix(in srgb, {{ $p }} 70%, #000); }
.why-icon-wrap { text-align:center; }
.partner-card { transition:transform 0.2s,box-shadow 0.2s; }
.partner-card:hover { transform:translateY(-4px);box-shadow:0 8px 24px rgba(0,0,0,0.1); }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper !== 'undefined' && document.querySelector('.hero-swiper')) {
        new Swiper('.hero-swiper', {
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.hero-pagination', clickable: true },
            navigation: { nextEl: '.hero-next', prevEl: '.hero-prev' },
        });
    }
});
</script>
@endpush

@endsection
