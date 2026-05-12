@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'من نحن':'About Us') . ' | مؤسسة رؤيا الإنسانية')
@section('description', $locale==='ar'?'تعرّف على مؤسسة رؤيا الإنسانية، رسالتنا، رؤيتنا، وأهدافنا الإنسانية.':'Learn about Roaya Insanya Foundation, our mission, vision and goals.')

@section('content')

{{-- Page Hero --}}
<section class="page-hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url($locale) }}">{{ $locale==='ar'?'الرئيسية':'Home' }}</a></li>
                        <li class="breadcrumb-item active">{{ $locale==='ar'?'من نحن':'About Us' }}</li>
                    </ol>
                </nav>
                <h1 class="section-title">{{ $locale==='ar'?'من نحن':'About Us' }}</h1>
                <p class="muted-color mt-3">{{ $locale==='ar'?'مؤسسة أهلية غير ربحية تعمل على نشر الخير وتقديم العون للمحتاجين.':'A non-profit foundation working to spread goodness and support those in need.' }}</p>
            </div>
        </div>
    </div>
</section>

{{-- About Intro --}}
<section class="main-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h6 class="main-color">{{ $locale==='ar'?'تعرّف علينا':'Who We Are' }}</h6>
                <h2 class="section-title mb-4">{{ $locale==='ar'?'مؤسسة رؤيا الإنسانية':'Roaya Insanya Foundation' }}</h2>
                <p class="muted-color" style="line-height:2">
                    {{ $locale==='ar'
                        ? 'مؤسسة رؤيا الإنسانية هي مؤسسة أهلية غير ربحية تعمل في إطار القوانين التركية، وتُعنى بتقديم خدمات إنسانية وإغاثية تستهدف الفئات الأكثر هشاشة في مناطق النزاع والكوارث.'
                        : 'Roaya Insanya is a non-profit organization operating under Turkish law, providing humanitarian and relief services targeting the most vulnerable groups in conflict and disaster zones.'
                    }}
                </p>
                <p class="muted-color" style="line-height:2">
                    {{ $locale==='ar'
                        ? 'نسعى إلى أن يكون كل تبرع أثرًا حقيقيًا يصل مباشرةً إلى المحتاجين بكل شفافية ومسؤولية.'
                        : 'We strive for every donation to create a real impact, reaching those in need with full transparency and responsibility.'
                    }}
                </p>
                <div class="row mt-4 g-3">
                    <div class="col-6">
                        <div class="about-stat-card">
                            <div class="about-stat-num main-color">+50,000</div>
                            <div class="about-stat-label">{{ $locale==='ar'?'مستفيد':'Beneficiaries' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="about-stat-card">
                            <div class="about-stat-num main-color">+200</div>
                            <div class="about-stat-label">{{ $locale==='ar'?'مشروع منجز':'Completed Projects' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="about-stat-card">
                            <div class="about-stat-num main-color">+10</div>
                            <div class="about-stat-label">{{ $locale==='ar'?'دولة نعمل بها':'Countries' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="about-stat-card">
                            <div class="about-stat-num main-color">+5</div>
                            <div class="about-stat-label">{{ $locale==='ar'?'سنوات خبرة':'Years of Experience' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://roaya-ansany.com/storage/uploads/pages/dWfpjiaOmZUcA0BC2wvyPZotctgE6L3TwskmdcsO.jpg"
                     class="img-fluid rounded-4" alt="about roaya" style="box-shadow:0 10px 40px rgba(90,158,47,0.2)">
            </div>
        </div>
    </div>
</section>

{{-- Mission & Vision --}}
<section class="main-section" style="background:#f8fdf4">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="main-color">{{ $locale==='ar'?'هويتنا':'Our Identity' }}</h6>
            <h2 class="section-title">{{ $locale==='ar'?'رسالتنا ورؤيتنا وهدفنا':'Mission, Vision & Goal' }}</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="mv-card">
                    <div class="mv-icon"><i class="fa-solid fa-bullseye fa-2x main-color"></i></div>
                    <h4 class="mt-3 mb-2">{{ $locale==='ar'?'هدفنا':'Our Goal' }}</h4>
                    <p class="muted-color">{{ $locale==='ar'?'الوصول إلى الفئات المستحقة وذوي الدخل المحدود لتحقيق الاكتفاء الذاتي وبناء مصادر دخل مستقلة.':'Reaching deserving groups and low-income families to achieve self-sufficiency and build independent income sources.' }}</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mv-card featured">
                    <div class="mv-icon"><i class="fa-solid fa-envelope-open-text fa-2x"></i></div>
                    <h4 class="mt-3 mb-2">{{ $locale==='ar'?'رسالتنا':'Our Mission' }}</h4>
                    <p>{{ $locale==='ar'?'تقديم المساعدة الإنسانية والإغاثية للفئات الأكثر هشاشة في مناطق النزاع والأزمات الإنسانية بكل شفافية ومسؤولية.':'Providing humanitarian and relief assistance to the most vulnerable groups in conflict and crisis areas with full transparency and accountability.' }}</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mv-card">
                    <div class="mv-icon"><i class="fa-solid fa-eye fa-2x main-color"></i></div>
                    <h4 class="mt-3 mb-2">{{ $locale==='ar'?'رؤيتنا':'Our Vision' }}</h4>
                    <p class="muted-color">{{ $locale==='ar'?'التنمية والريادة في العمل الإنساني وأن نكون المرجع الأول للمتبرعين الراغبين في إحداث فرق حقيقي.':'Development and leadership in humanitarian work, becoming the primary reference for donors seeking to make a real difference.' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Fields of Work --}}
<section class="main-section">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="main-color">{{ $locale==='ar'?'مجالات العمل':'Fields of Work' }}</h6>
            <h2 class="section-title">{{ $locale==='ar'?'المجالات والمشاريع المدعومة بالتبرعات':'Donation-Supported Fields & Projects' }}</h2>
        </div>
        <div class="row g-4">
            @foreach([
                ['icon'=>'fa-house-crack',    'title'=>($locale==='ar'?'إعادة الإعمار':'Reconstruction'),            'desc'=>($locale==='ar'?'بناء وترميم المنازل والمرافق المدمرة.':'Building and restoring destroyed homes and facilities.')],
                ['icon'=>'fa-bowl-food',       'title'=>($locale==='ar'?'الأمن الغذائي':'Food Security'),              'desc'=>($locale==='ar'?'توزيع طرود غذائية ووجبات ساخنة للأسر المحتاجة.':'Distributing food packages and hot meals to needy families.')],
                ['icon'=>'fa-droplet',         'title'=>($locale==='ar'?'مياه وصرف صحي':'Water & Sanitation'),        'desc'=>($locale==='ar'?'حفر الآبار وتوفير المياه النظيفة.':'Well drilling and providing clean water.')],
                ['icon'=>'fa-child-reaching',  'title'=>($locale==='ar'?'كفالة الأيتام':'Orphan Sponsorship'),         'desc'=>($locale==='ar'?'رعاية الأيتام وكفالتهم تعليميًا وصحيًا.':'Caring for orphans educationally and medically.')],
                ['icon'=>'fa-book-open',       'title'=>($locale==='ar'?'التعليم':'Education'),                       'desc'=>($locale==='ar'?'دعم المدارس وبناء الفصول الدراسية.':'Supporting schools and building classrooms.')],
                ['icon'=>'fa-heart-pulse',     'title'=>($locale==='ar'?'الصحة الطارئة':'Emergency Health'),          'desc'=>($locale==='ar'?'توفير الأدوية والرعاية الصحية العاجلة.':'Providing medicines and urgent healthcare.')],
            ] as $field)
            <div class="col-lg-4 col-md-6">
                <div class="field-card">
                    <div class="field-icon"><i class="fa-solid {{ $field['icon'] }} fa-xl main-color"></i></div>
                    <h5 class="mt-3 mb-2">{{ $field['title'] }}</h5>
                    <p class="muted-color mb-0">{{ $field['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="main-section">
    <div class="container">
        <div class="donate overflow-hidden">
            <div class="content">
                <h2 class="main-title text-white mb-4">{{ $locale==='ar'?'انضم إلينا وكن جزءًا من رحلة العطاء':'Join Us & Be Part of the Giving Journey' }}</h2>
                <p>{{ $locale==='ar'?'تبرعك مهما صغر يصنع أثرًا لا يُنسى.':'Your donation, no matter how small, creates an unforgettable impact.' }}</p>
                <div class="mt-4 holder">
                    <input type="text" name="amount" class="form-input" placeholder="{{ $locale==='ar'?'ادخل المبلغ':'Enter amount' }}">
                    <button type="button" class="btn-donate">{{ $locale==='ar'?'تبرع الآن':'Donate Now' }}</button>
                </div>
            </div>
            <img src="https://roaya-ansany.com/website/images/donate-child.svg" class="d-none d-lg-block" alt="donate">
        </div>
    </div>
</section>

@push('styles')
<style>
.page-hero-section { background: linear-gradient(135deg,#f8fdf4,#eef7e6); padding: 60px 0 40px; }
.page-hero-section .breadcrumb-item a { color: #5a9e2f; text-decoration: none; }
.about-stat-card { background:#f8fdf4; border-radius:12px; padding:20px; text-align:center; border:1px solid rgba(90,158,47,0.15); }
.about-stat-num { font-size:1.8rem; font-weight:800; }
.about-stat-label { font-size:13px; color:#888; margin-top:4px; }
.mv-card { background:#f8fdf4; border-radius:20px; padding:35px 25px; text-align:center; height:100%; border:2px solid transparent; transition:all 0.3s; }
.mv-card:hover { border-color:#5a9e2f; transform:translateY(-4px); }
.mv-card.featured { background:linear-gradient(135deg,#5a9e2f,#7bc244); color:white; }
.mv-card.featured p, .mv-card.featured h4 { color:white; }
.mv-icon { width:70px; height:70px; border-radius:50%; background:rgba(90,158,47,0.1); display:flex; align-items:center; justify-content:center; margin:0 auto; }
.mv-card.featured .mv-icon { background:rgba(255,255,255,0.2); }
.mv-card.featured .mv-icon i { color:white; }
.field-card { background:white; border:1px solid #e8f4d9; border-radius:16px; padding:30px 25px; height:100%; transition:all 0.3s; }
.field-card:hover { border-color:#5a9e2f; box-shadow:0 8px 24px rgba(90,158,47,0.15); transform:translateY(-3px); }
.field-icon { width:56px; height:56px; background:#f0f9e8; border-radius:12px; display:flex; align-items:center; justify-content:center; }
</style>
@endpush
@endsection
