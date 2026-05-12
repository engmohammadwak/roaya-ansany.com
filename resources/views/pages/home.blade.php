@extends('layouts.app')

@php $locale = app()->getLocale(); @endphp

@section('title', $locale === 'ar' ? 'الرئيسية | مؤسسة رؤيا الإنسانية' : 'Home | Roaya Insanya')
@section('description', $locale === 'ar' ? 'ساهم في إنقاذ الأرواح ودعم المحتاجين عبر حملات مؤسسة رؤيا الإنسانية.' : 'Help save lives through Roaya Insanya campaigns.')

@section('content')

{{-- ============ HERO BANNER ============ --}}
@php
    $hero = $data['hero'] ?? $data['page'] ?? null;
    $heroTitle = $hero['title'] ?? ($locale === 'ar' ? 'أنقذوا غزة الآن الحياة لا تنتظر، وتبرعك يصنع الفرق' : 'Save Gaza Now — Your donation makes a difference');
    $heroDesc  = $hero['description'] ?? ($locale === 'ar' ? 'ملايين المدنيين يواجهون الجوع والتشرد ونقص الاحتياجات الأساسية.' : 'Millions of civilians face hunger, displacement, and lack of basic needs.');
    $heroImg   = $hero['image'] ?? 'https://roaya-ansany.com/storage/uploads/pages/3PCwY0bnxr9NmLyHvTlL7wlNmBC5ir5vBG5gv0Wz.png';
@endphp
<section class="hero-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <h1 class="main-title">{!! $heroTitle !!}</h1>
                <p class="main-p my-3 my-lg-5">{{ $heroDesc }}</p>
                <form action="#">
                    <div class="row">
                        <div class="col-lg-9 col-8">
                            <input type="text" name="amount" id="amount" class="form-input w-100"
                                placeholder="{{ $locale === 'ar' ? 'ادخل المبلغ' : 'Enter amount' }}">
                        </div>
                        <div class="col-lg-3 col-4">
                            <button type="submit" class="btn-donate w-100">
                                {{ $locale === 'ar' ? 'تبرع الآن' : 'Donate Now' }}
                            </button>
                        </div>
                        <div class="col-md-12">
                            <div class="progress-container mt-4">
                                <div class="progress-bar"><div style="width:100%" class="progress-fill"></div></div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="banner-footer">
                    <div class="d-flex align-items-center">
                        <img width="27" height="27" class="me-3" src="https://roaya-ansany.com/website/images/verified.svg" alt="verified">
                        <p class="muted-color">
                            {{ $locale === 'ar' ? 'تبرعاتكم تُدار بشفافية كاملة، وتصل مباشرةً إلى المستفيدين عبر مشاريع إغاثية موثّقة.' : 'Your donations are managed with full transparency and reach beneficiaries directly.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="clipped-image-container">
                    <svg class="clipped-image" viewBox="0 0 441 388" preserveAspectRatio="none">
                        <path d="M43 0C19.2518 0 0 19.2518 0 43V345C0 368.748 19.2518 388 43 388H398C421.748 388 441 368.748 441 345V115C441 98.9837 428.016 86 412 86H329C312.984 86 300 73.0163 300 57V29C300 12.9837 287.016 0 271 0H43Z" fill="rgba(139, 195, 74, 0.15)"/>
                    </svg>
                    <div class="text-cut">{{ $locale === 'ar' ? 'تبرعك سينقذ الكثير من الأشخاص' : 'Your donation will save many lives' }}</div>
                    <div class="clipped-image">
                        <img width="510" height="430" src="{{ $heroImg }}" alt="banner">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ CAMPAIGN BANNER ============ --}}
@php
    $campaignBanner = $data['campaign_banner'] ?? $data['section'] ?? null;
    $cbImg    = $campaignBanner['image'] ?? 'https://roaya-ansany.com/storage/uploads/pages/94VHn4ZdEJ3QxaD8xMoObV8IGHOyvRDM9jqXGtKV.jpg';
    $cbTitle  = $campaignBanner['title'] ?? ($locale === 'ar' ? 'رابطة علماء فلسطين تؤكد التزام مؤسسة رؤيا الإنسانية' : 'Palestine Scholars Association confirms Roaya Insanya commitment');
    $cbDesc   = $campaignBanner['description'] ?? ($locale === 'ar' ? 'أصدرت رابطة علماء فلسطين بيانًا رسميًا أكدت فيه التزام مؤسسة رؤيا الإنسانية بالشفافية والضوابط الشرعية.' : 'The Palestine Scholars Association issued an official statement confirming Roaya Insanya commitment to transparency.');
@endphp
<section class="main-section">
    <div class="container">
        <div class="campaign-banner">
            <div class="row">
                <div class="col-md-5 order-2 order-lg-1">
                    <img src="{{ $cbImg }}" class="img-fluid" alt="campaign">
                </div>
                <div class="col-md-7 order-1 order-lg-2">
                    <h2 class="section-title mt-4">{{ $cbTitle }}</h2>
                    <p class="mt-4 color-67">{{ $cbDesc }}</p>
                    <form action="#" class="mt-4">
                        <div class="row">
                            <div class="col-9">
                                <input type="text" name="amount" class="form-input gray w-100"
                                    placeholder="{{ $locale === 'ar' ? 'ادخل المبلغ' : 'Enter amount' }}">
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn-donate w-100">{{ $locale === 'ar' ? 'تبرع الآن' : 'Donate Now' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ WHY DONATE ============ --}}
@php
    $whyCards = $data['why_donate'] ?? $data['features'] ?? [];
    $defaultCards = [
        ['title' => ($locale==='ar'?'الأطفال والنساء بلا مأوى':'Children & Women Without Shelter'), 'description' => ($locale==='ar'?'نهتم بالأطفال والنساء الذين هُدمت منازلهم.':'We care for children and women whose homes were destroyed.')],
        ['title' => ($locale==='ar'?'الأطفال والنساء بلا غذاء':'Children & Women Without Food'), 'description' => ($locale==='ar'?'نقدّم الدعم للأسر التي تعاني من شبح المجاعة.':'We support families suffering from famine.')],
        ['title' => ($locale==='ar'?'الأسر النازحة':'Displaced Families'), 'description' => ($locale==='ar'?'نهتم بالأسر التي نزحت إلى مراكز الإيواء.':'We care for families displaced to shelters.')],
        ['title' => ($locale==='ar'?'توزيع الطرود الغذائية':'Food Package Distribution'), 'description' => ($locale==='ar'?'نسعى إلى توفير طرود غذائية للأسر الفقيرة.':'We provide food packages for poor families.')],
        ['title' => ($locale==='ar'?'كفالة الأيتام والأرامل':'Orphan & Widow Sponsorship'), 'description' => ($locale==='ar'?'نساند الأيتام والنساء الأرامل.':'We support orphans and widows.')],
        ['title' => ($locale==='ar'?'مشاريع سقيا الماء':'Water Projects'), 'description' => ($locale==='ar'?'ندعم حفر الآبار وتوفير المياه.':'We support well drilling and water provision.')],
    ];
    if (empty($whyCards)) $whyCards = $defaultCards;
@endphp
<section class="main-section why-donate">
    <div class="container">
        <div class="header">
            <div>
                <h6>{{ $locale === 'ar' ? 'لماذا تتبرع لنا؟' : 'Why donate to us?' }}</h6>
                <h2 class="section-title">{{ $locale === 'ar' ? 'لأننا نهتم بالحالات الأكثر احتياجاً.' : 'Because we care about those in greatest need.' }}</h2>
            </div>
        </div>
        <div class="row mt-5">
            @foreach($whyCards as $card)
            <div class="col-lg-4 mb-4">
                <div class="why-donate-card">
                    <h5 class="mb-4">{{ $card['title'] ?? '' }}</h5>
                    <p class="mb-4">{{ $card['description'] ?? '' }}</p>
                    <div class="d-flex justify-content-between mt-3">
                        <input type="text" name="amount" class="form-input" placeholder="{{ $locale === 'ar' ? 'ادخل المبلغ' : 'Enter amount' }}">
                        <button type="button" class="btn-donate">{{ $locale === 'ar' ? 'تبرع' : 'Donate' }}</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ WHERE WE WORK ============ --}}
@php
    $about = $data['about'] ?? $data['organization'] ?? null;
    $aboutTitle = $about['title'] ?? ($locale==='ar'?'مؤسسة رؤيا الإنسانية':'Roaya Insanya');
    $aboutDesc  = $about['description'] ?? ($locale==='ar'?'مؤسسة رؤيا الإنسانية هي مؤسسة أهلية غير ربحية تعمل في إطار القوانين التركية.':'Roaya Insanya is a non-profit organization operating under Turkish law.');
    $aboutImg   = $about['image'] ?? 'https://roaya-ansany.com/storage/uploads/pages/dWfpjiaOmZUcA0BC2wvyPZotctgE6L3TwskmdcsO.jpg';
@endphp
<section class="main-section where-work">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="where-card">
                    <h2 class="section-title mb-4">{{ $aboutTitle }}</h2>
                    <p class="muted-color mb-3">{{ $aboutDesc }}</p>
                    <form action="">
                        <input type="text" name="amount" class="form-input w-100 mt-4" placeholder="{{ $locale === 'ar' ? 'ادخل المبلغ' : 'Enter amount' }}">
                        <div class="progress-container mt-4">
                            <div class="progress-bar"><div style="width:100%" class="progress-fill"></div></div>
                        </div>
                        <a href="{{ url($locale.'/donate') }}" class="btn-donate text-center mt-3">{{ $locale === 'ar' ? 'تبرع' : 'Donate' }}</a>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="why-imgs">
                    <img src="{{ $aboutImg }}" class="img-fluid" alt="about">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ STATS CARD ============ --}}
@php
    $statsImg = $data['stats_image'] ?? 'https://roaya-ansany.com/website/images/stats-card.png';
    $statsTitle = $data['stats_title'] ?? ($locale==='ar'?'الإغاثة العاجلة لأهل غزة، لبنان، شمال سوريا، السودان ودعم المحتاجين في تركيا':'Emergency relief for Gaza, Lebanon, North Syria, Sudan and Turkey');
    // Try to pull stats from projects API data
    $totalGoal    = collect($projects['data'] ?? [])->sum('goal_amount');
    $totalRaised  = collect($projects['data'] ?? [])->sum('raised_amount');
    $totalRemain  = max(0, $totalGoal - $totalRaised);
@endphp
<section class="main-section">
    <div class="container">
        <div class="stats-card">
            <img src="{{ $statsImg }}" class="img-fluid" alt="kids">
            <div class="text-center pt-5">
                <p class="text-white">{{ $locale === 'ar' ? 'مشاريع رؤيا تقدم لـ' : 'Roaya projects offer' }}</p>
                <h2 class="text-white mt-4 section-title">{{ $statsTitle }}</h2>
            </div>
            <div class="stats mt-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat w-100 mb-3">
                            <span>{{ $locale === 'ar' ? 'المتبقي' : 'Remaining' }}</span>
                            <span>${{ number_format($totalRemain) }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat w-100 mb-3">
                            <span>{{ $locale === 'ar' ? 'المبلغ المُجمَّع' : 'Raised' }}</span>
                            <span>${{ number_format($totalRaised) }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat w-100 mb-3">
                            <span>{{ $locale === 'ar' ? 'الهدف' : 'Goal' }}</span>
                            <span>${{ number_format($totalGoal) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center my-5">
                <a href="{{ url($locale.'/donate') }}" class="btn-donate mx-auto w-20 bg-white">{{ $locale === 'ar' ? 'تبرع الآن' : 'Donate Now' }}</a>
            </div>
        </div>
    </div>
</section>

{{-- ============ SUPPORT SECTION ============ --}}
@php
    $support = $data['support'] ?? null;
    $supportImg   = $support['image'] ?? 'https://roaya-ansany.com/storage/uploads/pages/JDqjlXwu5odPJit3bTMC8NQxssv8OKDDNyPeVwPS.jpg';
    $supportItems = $support['items'] ?? [
        ($locale==='ar'?'مشاريع إغاثة المياه':'Water relief projects'),
        ($locale==='ar'?'برامج كفالة الأيتام':'Orphan sponsorship programs'),
        ($locale==='ar'?'توفير طرود غذائية ووجبات':'Food packages and meals'),
        ($locale==='ar'?'تجديد مراكز الإيواء':'Shelter renovation'),
        ($locale==='ar'?'تقديم مساعدات نقدية':'Cash assistance for families'),
    ];
@endphp
<section class="main-section">
    <div class="container">
        <div class="support">
            <div class="row">
                <div class="col-md-5 mb-5">
                    <img class="w-lg-100 img-fluid" src="{{ $supportImg }}" alt="support">
                </div>
                <div class="col-md-7">
                    <div class="content">
                        <h2 class="section-title mb-4">{{ $locale === 'ar' ? 'مؤسسة رؤيا الإنسانية' : 'Roaya Insanya' }}</h2>
                        <p class="muted-color">{{ $locale === 'ar' ? 'مؤسسة خيرية غير ربحية تعمل في المجال الإنساني.' : 'A non-profit charitable organization working in the humanitarian field.' }}</p>
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
@php $partners = $data['partners'] ?? []; @endphp
<section class="main-section">
    <div class="container">
        <p class="color-67 text-center">{{ $locale === 'ar' ? 'الشركاء' : 'Partners' }}</p>
        <h2 class="text-center section-title mx-auto my-3">{{ $locale === 'ar' ? 'موثوق بها من جهات إنسانية وخيرية' : 'Trusted by humanitarian organizations' }}</h2>
        <p class="color-67 text-center">
            {{ $locale === 'ar' ? 'هل ستنقذ روحًا؟' : 'Will you save a soul?' }}
            <a href="{{ url($locale.'/donate') }}" class="main-color">{{ $locale === 'ar' ? 'تبرع الآن' : 'Donate Now' }}</a>
        </p>
        @if(!empty($partners))
        <div class="d-flex sponser-imgs mt-5 flex-wrap justify-content-center gap-4">
            @foreach($partners as $partner)
            <div class="text-center mx-4">
                <img src="{{ $partner['image'] ?? $partner['logo'] ?? '' }}" alt="{{ $partner['name'] ?? '' }}" class="img-fluid" style="max-height:160px; object-fit:contain">
                <p class="mt-2 color-67">{{ $partner['name'] ?? '' }}</p>
            </div>
            @endforeach
        </div>
        @else
        <div class="d-flex sponser-imgs mt-5 flex-wrap justify-content-center gap-4">
            <div class="text-center mx-4">
                <img src="https://roaya-ansany.com/website/images/sponser/هيئة-الزكاة-الفلسطينية-150x150.jpg" alt="هيئة الزكاة الفلسطينية" class="img-fluid" style="max-height:160px; object-fit:contain">
                <p class="mt-2 color-67">هيئة الزكاة الفلسطينية</p>
            </div>
            <div class="text-center mx-4">
                <img src="https://roaya-ansany.com/website/images/sponser/معهد-الأمل-للأيتام-150x150.png" alt="معهد الأمل للأيتام" class="img-fluid" style="max-height:160px; object-fit:contain">
                <p class="mt-2 color-67">معهد الأمل للأيتام</p>
            </div>
            <div class="text-center mx-4">
                <img src="https://roaya-ansany.com/website/images/sponser/وزارة-التنمية-الإجتماعية-150x150.jpg" alt="وزارة التنمية الإجتماعية" class="img-fluid" style="max-height:160px; object-fit:contain">
                <p class="mt-2 color-67">وزارة التنمية الإجتماعية</p>
            </div>
        </div>
        @endif
    </div>
</section>

{{-- ============ CTA DONATE ============ --}}
<section class="main-section">
    <div class="container">
        <div class="donate overflow-hidden">
            <div class="content">
                <h2 class="main-title text-white mb-4">{{ $locale === 'ar' ? 'تبرّع الآن — أنقذ حياة' : 'Donate Now — Save Lives' }}</h2>
                <p>{{ $locale === 'ar' ? 'تبرّع الآن وأنقذ حياة. مساهمتك، مهما كانت صغيرة، تصنع تأثيرًا دائمًا.' : 'Donate now and save lives. Your contribution, no matter how small, makes a lasting impact.' }}</p>
                <div class="mt-4 holder">
                    <input type="text" name="amount" id="amount888" class="form-input" placeholder="{{ $locale === 'ar' ? 'ادخل المبلغ' : 'Enter amount' }}">
                    <button type="button" class="btn-donate">{{ $locale === 'ar' ? 'تبرع' : 'Donate' }}</button>
                </div>
            </div>
            <img src="https://roaya-ansany.com/website/images/donate-child.svg" class="d-none d-lg-block" alt="donate">
        </div>
    </div>
</section>

@endsection
