

<?php
    $locale = app()->getLocale();
    $p = App\Models\Setting::get('color_primary', '#9dcc6b');

    $hero      = $data['hero'] ?? [];
    $heroTitle = $hero['title']       ?? ($locale==='ar' ? 'أنقذوا غزة الآن' : 'Save Gaza Now');
    $heroDesc  = $hero['description'] ?? ($locale==='ar' ? 'ملايين المدنيين يواجهون الجوع والتشرد.' : 'Millions face hunger and displacement.');
    $heroImg   = $hero['image']       ?? 'https://roaya-ansany.com/storage/uploads/pages/3PCwY0bnxr9NmLyHvTlL7wlNmBC5ir5vBG5gv0Wz.png';

    $heroLabel = $locale === 'ar'
        ? App\Models\Setting::get('hero_label_ar', '')
        : App\Models\Setting::get('hero_label_en', '');
?>

<?php $__env->startSection('title', $locale === 'ar' ? 'الرئيسية' : 'Home'); ?>
<?php $__env->startSection('description', $locale === 'ar' ? 'ساهم في إنقاذ الأرواح ودعم المحتاجين عبر حملاتنا.' : 'Help save lives through our campaigns.'); ?>

<?php $__env->startSection('content'); ?>


<?php $sliderProjects = array_slice($projects['data'] ?? [], 0, 5); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($sliderProjects)): ?>
<section class="hero-slider-section" style="position:relative">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroLabel): ?>
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
        <?php echo e($heroLabel); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="hero-swiper swiper">
        <div class="swiper-wrapper">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sliderProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $slideGoal   = $slide['goal_amount'] ?? 0;
                $slideRaised = $slide['raised_amount'] ?? 0;
                $slidePct    = $slideGoal > 0 ? min(100, round(($slideRaised / $slideGoal) * 100)) : 0;
                $slideImg    = $slide['image'] ?? $slide['thumbnail'] ?? 'https://roaya-ansany.com/website/images/stats-card.png';
                $slideTitle  = $slide['title'] ?? $slide['name'] ?? '';
                $slideSlug   = $slide['slug'] ?? $slide['id'] ?? '';
            ?>
            <div class="swiper-slide">
                <div class="hero-slide" style="background-image:url('<?php echo e($slideImg); ?>')">
                    <div class="hero-slide-overlay"></div>
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-lg-7">
                                <div class="hero-slide-content">
                                    <h2 class="hero-slide-title"><?php echo e($slideTitle); ?></h2>
                                    <div class="slide-progress mt-3 mb-2">
                                        <div class="slide-progress-bar">
                                            <div class="slide-progress-fill" style="width:<?php echo e($slidePct); ?>%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2 text-white" style="font-size:13px">
                                            <span><?php echo e($locale==='ar'?'تم جمعه':'Raised'); ?>: $<?php echo e(number_format($slideRaised)); ?></span>
                                            <span><?php echo e($slidePct); ?>%</span>
                                            <span><?php echo e($locale==='ar'?'الهدف':'Goal'); ?>: $<?php echo e(number_format($slideGoal)); ?></span>
                                        </div>
                                    </div>
                                    <a href="<?php echo e(url($locale.'/campaigns/'.$slideSlug)); ?>" class="btn-donate mt-3 d-inline-block">
                                        <?php echo e($locale==='ar'?'تبرع الآن':'Donate Now'); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="swiper-pagination hero-pagination"></div>
        <div class="swiper-button-next hero-next"></div>
        <div class="swiper-button-prev hero-prev"></div>
    </div>
</section>
<?php else: ?>

<section class="hero-banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-sm-12">
                <h1 class="main-title"><?php echo $heroTitle; ?></h1>
                <p class="main-p my-3 my-lg-5"><?php echo e($heroDesc); ?></p>
                <form action="#">
                    <div class="row">
                        <div class="col-lg-9 col-8">
                            <input type="text" name="amount" class="form-input w-100" placeholder="<?php echo e($locale==='ar'?'ادخل المبلغ':'Enter amount'); ?>">
                        </div>
                        <div class="col-lg-3 col-4">
                            <button type="submit" class="btn-donate w-100"><?php echo e($locale==='ar'?'تبرع الآن':'Donate Now'); ?></button>
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
                        <p class="muted-color"><?php echo e($locale==='ar'?'تبرعاتكم تُدار بشفافية كاملة وتصل مباشرةً إلى المستفيدين.':'Donations managed with full transparency and reach beneficiaries directly.'); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="clipped-image-container" style="position:relative">
                    <svg viewBox="0 0 441 388" preserveAspectRatio="none" style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:0">
                        <path d="M43 0C19.2518 0 0 19.2518 0 43V345C0 368.748 19.2518 388 43 388H398C421.748 388 441 368.748 441 345V115C441 98.9837 428.016 86 412 86H329C312.984 86 300 73.0163 300 57V29C300 12.9837 287.016 0 271 0H43Z" fill="<?php echo e($p); ?>" fill-opacity="0.15"/>
                    </svg>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroLabel): ?>
                    <div style="position:absolute;top:12px;left:351px;right:0;text-align:center;z-index:2;font-size:14px;color:#555;font-weight:500;">
                        <?php echo e($heroLabel); ?>

                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <img width="510" height="430" src="<?php echo e($heroImg); ?>" alt="banner" style="position:relative;z-index:1;width:100%;border-radius:20px">
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php
    $cb         = $data['campaign_banner'] ?? [];
    $cbImg      = $cb['image']       ?? 'https://roaya-ansany.com/storage/uploads/pages/94VHn4ZdEJ3QxaD8xMoObV8IGHOyvRDM9jqXGtKV.jpg';
    $cbTitle    = $cb['title']       ?? ($locale==='ar' ? 'رابطة علماء فلسطين تُشيد بمؤسستنا' : 'Palestine Scholars praise us');
    $cbSubtitle = $cb['subtitle']    ?? ($locale==='ar' ? 'تؤكد الالتزام بالشفافية والضوابط الشرعية' : 'Confirms commitment to transparency and Sharia standards');
    $cbDesc     = $cb['description'] ?? ($locale==='ar' ? 'أصدرت رابطة علماء فلسطين بيانًا رسميًا أكدت فيه التزامنا.' : 'The Palestine Scholars Association issued an official statement.');
    $cbAlign    = $locale === 'ar' ? 'right' : 'left';
?>
<section class="main-section">
    <div class="container">
        <div class="campaign-banner">
            <div class="row align-items-center">
                <div class="col-md-5 order-2 order-lg-1">
                    <img src="<?php echo e($cbImg); ?>" class="img-fluid rounded-3" alt="campaign">
                </div>
                <div class="col-md-7 order-1 order-lg-2 ps-lg-5" dir="<?php echo e($locale === 'ar' ? 'rtl' : 'ltr'); ?>">
                    <h2 class="section-title mt-4" style="text-align:<?php echo e($cbAlign); ?>"><?php echo e($cbTitle); ?></h2>
                    <h6 class="mt-2 mb-3" style="font-size:15px;font-weight:600;color:var(--main-color);text-align:<?php echo e($cbAlign); ?>"><?php echo e($cbSubtitle); ?></h6>
                    <p class="color-67" style="font-size:14px;line-height:1.9;text-align:<?php echo e($cbAlign); ?>"><?php echo e($cbDesc); ?></p>
                    <form action="#" class="mt-4">
                        <div class="row">
                            <div class="col-9"><input type="text" name="amount" class="form-input gray w-100" placeholder="<?php echo e($locale==='ar'?'ادخل المبلغ':'Enter amount'); ?>"></div>
                            <div class="col-3"><button type="submit" class="btn-donate w-100"><?php echo e($locale==='ar'?'تبرع الآن':'Donate Now'); ?></button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<?php $homeProjects = array_slice($projects['data'] ?? [], 0, 6); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($homeProjects)): ?>
<section class="main-section">
    <div class="container">
        <div class="header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6><?php echo e($locale==='ar'?'حملاتنا':'Our Campaigns'); ?></h6>
                <h2 class="section-title"><?php echo e($locale==='ar'?'أحدث حملات التبرع':'Latest Donation Campaigns'); ?></h2>
            </div>
            <a href="<?php echo e(url($locale.'/campaigns')); ?>" class="btn-outline"><?php echo e($locale==='ar'?'عرض الكل':'View All'); ?></a>
        </div>
        <div class="row">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $homeProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $pGoal   = $proj['goal_amount'] ?? 0;
                $pRaised = $proj['raised_amount'] ?? 0;
                $pPct    = $pGoal > 0 ? min(100, round(($pRaised / $pGoal) * 100)) : 0;
                $pImg    = $proj['image'] ?? $proj['thumbnail'] ?? 'https://roaya-ansany.com/website/images/stats-card.png';
                $pTitle  = $proj['title'] ?? $proj['name'] ?? '';
                $pSlug   = $proj['slug'] ?? $proj['id'] ?? '';
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="campaign-card h-100">
                    <img src="<?php echo e($pImg); ?>" class="img-fluid w-100" alt="<?php echo e($pTitle); ?>" style="height:200px;object-fit:cover;border-radius:12px 12px 0 0">
                    <div class="campaign-card-body p-3">
                        <h5 class="campaign-card-title mb-3"><?php echo e($pTitle); ?></h5>
                        <div class="progress-container mb-2"><div class="progress-bar"><div class="progress-fill" style="width:<?php echo e($pPct); ?>%"></div></div></div>
                        <div class="d-flex justify-content-between text-muted mb-3" style="font-size:13px">
                            <div class="text-center"><div class="fw-bold" style="color:var(--main-color)">$<?php echo e(number_format($pRaised)); ?></div><div><?php echo e($locale==='ar'?'تم جمعه':'Raised'); ?></div></div>
                            <div class="text-center"><div class="fw-bold"><?php echo e($pPct); ?>%</div><div><?php echo e($locale==='ar'?'مكتمل':'Complete'); ?></div></div>
                            <div class="text-center"><div class="fw-bold">$<?php echo e(number_format($pGoal)); ?></div><div><?php echo e($locale==='ar'?'الهدف':'Goal'); ?></div></div>
                        </div>
                        <a href="<?php echo e(url($locale.'/campaigns/'.$pSlug)); ?>" class="btn-donate w-100 text-center d-block"><?php echo e($locale==='ar'?'تبرع الآن':'Donate Now'); ?></a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php
    $whyCards = $data['why_donate'] ?? [];
    $whyLabel = $data['why_donate_label'] ?? ($locale==='ar' ? 'لماذا تتبرع لنا؟' : 'Why donate to us?');

    // استخدام المفتاح الصحيح حسب اللغة
    $whyTitle = $locale === 'ar'
        ? (App\Models\Setting::get('why_donate_title_ar', '') ?: ($data['why_donate_title'] ?? 'لأننا نهتم بالحالات الأكثر احتياجًا.'))
        : (App\Models\Setting::get('why_donate_title_en', '') ?: ($data['why_donate_title'] ?? 'Because we care about those in greatest need.'));

    $defaultCards = [
        ['icon'=>'fa-house-crack',   'title'=>($locale==='ar'?'الأطفال والنساء بلا مأوى':'Children & Women Without Shelter'),      'description'=>($locale==='ar'?'نهتم بالأطفال والنساء الذين هُدمت منازلهم ويعيشون في الخيام ومراكز الإيواء.':'We care for children and women whose homes were destroyed.')],
        ['icon'=>'fa-bowl-food',     'title'=>($locale==='ar'?'الأطفال والنساء بلا غذاء':'Children & Women Without Food'),         'description'=>($locale==='ar'?'نقدّم الدعم للأسر التي تعاني من شبح المجاعة.':'We support families suffering from famine.')],
        ['icon'=>'fa-people-arrows', 'title'=>($locale==='ar'?'الأسر النازحة':'Displaced Families'),                       'description'=>($locale==='ar'?'نهتم بالأسر التي نزحت إلى مراكز الإيواء.':'We care for families displaced to shelters.')],
        ['icon'=>'fa-box-open',      'title'=>($locale==='ar'?'توزيع الطرود الغذائية':'Food Package Distribution'),              'description'=>($locale==='ar'?'نسعى إلى توفير طرود غذائية للأسر الفقيرة.':'We provide food packages for poor families.')],
        ['icon'=>'fa-child-reaching','title'=>($locale==='ar'?'كفالة الأيتام والأرامل':'Orphan & Widow Sponsorship'),            'description'=>($locale==='ar'?'نساند الأيتام والنساء الأرامل.':'We support orphans and widows.')],
        ['icon'=>'fa-droplet',       'title'=>($locale==='ar'?'مشاريع سقيا الماء':'Water Projects'),                              'description'=>($locale==='ar'?'ندعم حفر الآبار وتوفير المياه.':'We support well drilling and water provision.')],
    ];
    if (empty($whyCards)) $whyCards = $defaultCards;
    $whyAlign = $locale === 'ar' ? 'right' : 'left';
?>
<section class="main-section why-donate">
    <div class="container">
        <div class="why-donate-header" dir="<?php echo e($locale === 'ar' ? 'rtl' : 'ltr'); ?>">
            <h6 style="color:var(--main-color);font-size:15px;font-weight:600;text-align:<?php echo e($whyAlign); ?>;width:100%;display:block;"><?php echo e($whyLabel); ?></h6>
            <h6 style="font-size:32px;font-weight:600;color:var(--dark-text-color);margin:0;text-align:<?php echo e($whyAlign); ?>;width:100%;display:block;"><?php echo e($whyTitle); ?></h6>
        </div>
        <div class="row mt-5">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $whyCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $icon = $card['icon'] ?? 'fa-heart'; ?>
            <div class="col-lg-4 mb-4">
                <div class="why-donate-card">
                    <div class="why-icon-wrap mb-3">
                        <div class="why-icon-circle"><i class="fa-solid <?php echo e($icon); ?> fa-lg"></i></div>
                    </div>
                    <h5 class="mb-3"><?php echo e($card['title'] ?? ''); ?></h5>
                    <p class="mb-4"><?php echo e($card['description'] ?? ''); ?></p>
                    <div class="d-flex justify-content-between mt-3">
                        <input type="text" name="amount" class="form-input" placeholder="<?php echo e($locale==='ar'?'ادخل المبلغ':'Enter amount'); ?>">
                        <button type="button" class="btn-donate"><?php echo e($locale==='ar'?'تبرع':'Donate'); ?></button>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($programs) && !empty($programs['data'])): ?>
<section class="main-section">
    <div class="container">
        <div class="header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6><?php echo e($locale==='ar'?'برامجنا':'Our Programs'); ?></h6>
                <h2 class="section-title"><?php echo e($locale==='ar'?'البرامج الإنسانية':'Humanitarian Programs'); ?></h2>
            </div>
            <a href="<?php echo e(url($locale.'/campaigns')); ?>" class="btn-outline"><?php echo e($locale==='ar'?'عرض الكل':'View All'); ?></a>
        </div>
        <div class="row">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = array_slice($programs['data'], 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $pgImg    = $program['image'] ?? 'https://roaya-ansany.com/website/images/stats-card.png';
                $pgTitle  = $program['title'] ?? $program['name'] ?? '';
                $pgDesc   = $program['description'] ?? '';
                $pgSlug   = $program['slug'] ?? $program['id'] ?? '';
                $pgGoal   = $program['goal_amount'] ?? 0;
                $pgRaised = $program['raised_amount'] ?? 0;
                $pgPct    = $pgGoal > 0 ? min(100, round(($pgRaised / $pgGoal) * 100)) : 0;
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="program-card h-100">
                    <img src="<?php echo e($pgImg); ?>" class="img-fluid w-100" alt="<?php echo e($pgTitle); ?>" style="height:220px;object-fit:cover;border-radius:12px 12px 0 0">
                    <div class="p-4">
                        <h5 class="mb-2"><?php echo e($pgTitle); ?></h5>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pgDesc): ?><p class="color-67 mb-3" style="font-size:14px"><?php echo e(Str::limit(strip_tags($pgDesc), 100)); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pgGoal > 0): ?>
                        <div class="progress-container mb-2"><div class="progress-bar"><div class="progress-fill" style="width:<?php echo e($pgPct); ?>%"></div></div></div>
                        <div class="d-flex justify-content-between text-muted mb-3" style="font-size:13px">
                            <span><?php echo e($locale==='ar'?'تم جمعه':'Raised'); ?>: $<?php echo e(number_format($pgRaised)); ?></span>
                            <span><?php echo e($pgPct); ?>%</span>
                            <span><?php echo e($locale==='ar'?'الهدف':'Goal'); ?>: $<?php echo e(number_format($pgGoal)); ?></span>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <a href="<?php echo e(url($locale.'/campaigns/'.$pgSlug)); ?>" class="btn-donate w-100 text-center d-block"><?php echo e($locale==='ar'?'تبرع الآن':'Donate Now'); ?></a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php
    $about      = $data['about'] ?? [];
    $aboutTitle = $about['title']       ?? ($locale==='ar'?'من نحن':'About Us');
    $aboutDesc  = $about['description'] ?? ($locale==='ar'?'مؤسسة أهلية غير ربحية.':'Non-profit organization.');
    $aboutImg   = $about['image']       ?? 'https://roaya-ansany.com/storage/uploads/pages/dWfpjiaOmZUcA0BC2wvyPZotctgE6L3TwskmdcsO.jpg';
?>
<section class="main-section where-work">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="where-card">
                    <h2 class="section-title mb-4"><?php echo e($aboutTitle); ?></h2>
                    <p class="muted-color mb-3"><?php echo e($aboutDesc); ?></p>
                    <form action="">
                        <input type="text" name="amount" class="form-input w-100 mt-4" placeholder="<?php echo e($locale==='ar'?'ادخل المبلغ':'Enter amount'); ?>">
                        <div class="progress-container mt-4"><div class="progress-bar"><div style="width:100%" class="progress-fill"></div></div></div>
                        <a href="<?php echo e(url($locale.'/donate')); ?>" class="btn-donate text-center mt-3 d-block"><?php echo e($locale==='ar'?'تبرع':'Donate'); ?></a>
                    </form>
                </div>
            </div>
            <div class="col-md-6"><div class="why-imgs"><img src="<?php echo e($aboutImg); ?>" class="img-fluid" alt="about"></div></div>
        </div>
    </div>
</section>


<?php
    $statsImg   = $data['stats_image'] ?? 'https://roaya-ansany.com/website/images/stats-card.png';
    $statsTitle = $data['stats_title'] ?? ($locale==='ar'?'الإغاثة العاجلة لأهل غزة، لبنان، شمال سوريا، السودان ودعم المحتاجين في تركيا':'Emergency relief for Gaza, Lebanon, North Syria, Sudan and Turkey');
    $totalGoal   = collect($projects['data'] ?? [])->sum('goal_amount');
    $totalRaised = collect($projects['data'] ?? [])->sum('raised_amount');
    $totalRemain = max(0, $totalGoal - $totalRaised);
?>
<section class="main-section">
    <div class="container">
        <div class="stats-card">
            <img src="<?php echo e($statsImg); ?>" class="img-fluid" alt="kids">
            <div class="text-center pt-5">
                <p class="text-white"><?php echo e($locale==='ar'?'مشاريعنا تقدم لـ':'Our projects offer'); ?></p>
                <h2 class="text-white mt-4 section-title"><?php echo e($statsTitle); ?></h2>
            </div>
            <div class="stats mt-5">
                <div class="row">
                    <div class="col-md-4"><div class="stat w-100 mb-3"><span><?php echo e($locale==='ar'?'المتبقي':'Remaining'); ?></span><span>$<?php echo e(number_format($totalRemain)); ?></span></div></div>
                    <div class="col-md-4"><div class="stat w-100 mb-3"><span><?php echo e($locale==='ar'?'المبلغ المُجَمَع':'Raised'); ?></span><span>$<?php echo e(number_format($totalRaised)); ?></span></div></div>
                    <div class="col-md-4"><div class="stat w-100 mb-3"><span><?php echo e($locale==='ar'?'الهدف':'Goal'); ?></span><span>$<?php echo e(number_format($totalGoal)); ?></span></div></div>
                </div>
            </div>
            <div class="text-center my-5">
                <a href="<?php echo e(url($locale.'/donate')); ?>" class="btn-donate mx-auto bg-white"><?php echo e($locale==='ar'?'تبرع الآن':'Donate Now'); ?></a>
            </div>
        </div>
    </div>
</section>


<?php echo $__env->make('partials.donation-counter', ['donationCounter' => $data['donation_counter'] ?? []], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php
    $support      = $data['support'] ?? [];
    $supportImg   = $support['image'] ?? 'https://roaya-ansany.com/storage/uploads/pages/JDqjlXwu5odPJit3bTMC8NQxssv8OKDDNyPeVwPS.jpg';
    $supportItems = $support['items'] ?? [
        ($locale==='ar'?'مشاريع إغاثة المياه':'Water relief projects'),
        ($locale==='ar'?'برامج كفالة الأيتام':'Orphan sponsorship programs'),
        ($locale==='ar'?'توفير طرود غذائية ووجبات':'Food packages and meals'),
        ($locale==='ar'?'تجديد مراكز الإيواء':'Shelter renovation'),
        ($locale==='ar'?'تقديم مساعدات نقدية':'Cash assistance'),
    ];
?>
<section class="main-section">
    <div class="container">
        <div class="support">
            <div class="row">
                <div class="col-md-5 mb-5"><img class="w-lg-100 img-fluid" src="<?php echo e($supportImg); ?>" alt="support"></div>
                <div class="col-md-7">
                    <div class="content">
                        <h2 class="section-title mb-4"><?php echo e($locale==='ar'?'من نحن':'About Us'); ?></h2>
                        <p class="muted-color"><?php echo e($locale==='ar'?'مؤسسة خيرية غير ربحية تعمل في المجال الإنساني.':'A non-profit organization in the humanitarian field.'); ?></p>
                        <div class="container my-5" dir="<?php echo e($locale === 'ar' ? 'rtl' : 'ltr'); ?>">
                            <div class="row g-3 justify-content-center">
                                <div class="col-12 col-md-6">
                                    <ul class="numbered-list list-unstyled m-0">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = array_slice($supportItems, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><span><?php echo e($i+1); ?></span><p><?php echo e(is_array($item) ? ($item['title'] ?? '') : $item); ?></p></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </ul>
                                </div>
                                <div class="col-12 col-md-6">
                                    <ul class="numbered-list list-unstyled m-0">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = array_slice($supportItems, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><span><?php echo e($i+4); ?></span><p><?php echo e(is_array($item) ? ($item['title'] ?? '') : $item); ?></p></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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


<?php
    $partners = $data['partners'] ?? [];
    $defaultPartners = [
        ['name'=>($locale==='ar'?'هيئة الزكاة الفلسطينية':'Palestinian Zakat Authority'), 'icon'=>'fa-hand-holding-dollar','color'=>'#e8f4fd'],
        ['name'=>($locale==='ar'?'معهد الأمل للأيتام':'Al-Amal Institute for Orphans'),  'icon'=>'fa-children',           'color'=>'#edf7ee'],
        ['name'=>($locale==='ar'?'وزارة التنمية الاجتماعية':'Ministry of Social Development'),'icon'=>'fa-building-columns','color'=>'#fdf3e7'],
    ];
    if (empty($partners)) $partners = $defaultPartners;
?>
<section class="main-section">
    <div class="container">
        <p class="color-67 text-center"><i class="fa-solid fa-handshake me-2" style="color:var(--main-color)"></i><?php echo e($locale==='ar'?'الشركاء':'Partners'); ?></p>
        <h2 class="text-center section-title mx-auto my-3"><?php echo e($locale==='ar'?'موثوق بها من جهات إنسانية وخيرية':'Trusted by humanitarian organizations'); ?></h2>
        <p class="color-67 text-center mb-5"><?php echo e($locale==='ar'?'هل ستنقذ روحًا؟':'Will you save a soul?'); ?> <a href="<?php echo e(url($locale.'/donate')); ?>" style="color:var(--main-color);font-weight:bold"><?php echo e($locale==='ar'?'تبرع الآن':'Donate Now'); ?></a></p>
        <div class="row justify-content-center g-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $pName  = $partner['name']  ?? '';
                $pIcon  = $partner['icon']  ?? 'fa-handshake';
                $pColor = $partner['color'] ?? '#f0f7ff';
                $pImg   = $partner['image'] ?? $partner['logo'] ?? null;
            ?>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="partner-card text-center p-4" style="background:<?php echo e($pColor); ?>;border-radius:16px;border:1px solid rgba(0,0,0,0.06)">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pImg): ?>
                    <img src="<?php echo e($pImg); ?>" alt="<?php echo e($pName); ?>" class="img-fluid mb-3" style="max-height:70px;object-fit:contain">
                    <?php else: ?>
                    <div style="width:60px;height:60px;border-radius:50%;background:white;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;box-shadow:0 2px 8px rgba(0,0,0,0.1)">
                        <i class="fa-solid <?php echo e($pIcon); ?> fa-lg" style="color:var(--main-color)"></i>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <h6 class="mb-0" style="font-size:14px;font-weight:600"><?php echo e($pName); ?></h6>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>


<?php
    $faqs = $data['faqs'] ?? [];
    $defaultFaqs = [
        ['question'=>($locale==='ar'?'كيف يمكنني التبرع؟':'How can I donate?'), 'answer'=>($locale==='ar'?'عبر الموقع مباشرةً باختيار المشروع وإدخال المبلغ.':'Through the website by selecting a project and entering the amount.')],
        ['question'=>($locale==='ar'?'هل تبرعاتي تصل؟':'Do my donations reach?'), 'answer'=>($locale==='ar'?'نعم، 100% تصل للمستحقين عبر شركاء موثوقين.':'Yes, 100% reaches beneficiaries through trusted partners.')],
        ['question'=>($locale==='ar'?'هل يمكنني متابعة مشروعي؟':'Can I follow my project?'), 'answer'=>($locale==='ar'?'نعم، تقارير دورية وصور ميدانية لكل مشروع.':'Yes, periodic reports and field photos for each project.')],
        ['question'=>($locale==='ar'?'ما هي مشاريعكم؟':'What are your projects?'), 'answer'=>($locale==='ar'?'كفالة الأيتام، طرود غذائية، حفر آبار، بناء مساجد، دعم مرضى.':'Orphan sponsorship, food packages, well drilling, mosque construction.')],
        ['question'=>($locale==='ar'?'كيف أتواصل معكم؟':'How to contact you?'), 'answer'=>($locale==='ar'?'عبر صفحة اتصل بنا أو حساباتنا على التواصل الاجتماعي.':'Through the Contact Us page or our social media accounts.')],
    ];
    if (empty($faqs)) $faqs = $defaultFaqs;
?>
<section class="main-section faq-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <h6><?php echo e($locale==='ar'?'الأسئلة الشائعة':'FAQ'); ?></h6>
                <h2 class="section-title mb-4"><?php echo e($locale==='ar'?'أسئلة وأجوبة حول التبرع':'Q&A About Donating'); ?></h2>
                <p class="muted-color mb-4"><?php echo e($locale==='ar'?'إذا لم تجد إجابتك، تواصل معنا.':'If you don\'t find your answer, contact us.'); ?></p>
                <a href="<?php echo e(url($locale.'/contact')); ?>" class="btn-donate d-inline-block"><?php echo e($locale==='ar'?'تواصل معنا':'Contact Us'); ?></a>
            </div>
            <div class="col-lg-7">
                <div class="accordion faq-accordion" id="faqAccordion">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fi => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion-item faq-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?php echo e($fi>0?'collapsed':''); ?> faq-btn" type="button"
                                data-bs-toggle="collapse" data-bs-target="#faqC<?php echo e($fi); ?>" aria-expanded="<?php echo e($fi===0?'true':'false'); ?>">
                                <?php echo e($faq['question'] ?? ''); ?>

                            </button>
                        </h2>
                        <div id="faqC<?php echo e($fi); ?>" class="accordion-collapse collapse <?php echo e($fi===0?'show':''); ?>" data-bs-parent="#faqAccordion">
                            <div class="accordion-body faq-body"><?php echo e($faq['answer'] ?? ''); ?></div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
    $nlTitle = $data['newsletter_title'] ?? ($locale==='ar'?'اشترك في نشرتنا البريدية':'Subscribe to Our Newsletter');
    $nlDesc  = $data['newsletter_description'] ?? ($locale==='ar'?'احصل على آخر أخبار المشاريع مباشرةً في بريدك.':'Get the latest project news directly in your inbox.');
?>
<section class="main-section newsletter-section">
    <div class="container">
        <div class="newsletter-box text-center">
            <h6><?php echo e($locale==='ar'?'ابقَ على اطلاع':'Stay Updated'); ?></h6>
            <h2 class="section-title mb-3"><?php echo e($nlTitle); ?></h2>
            <p class="muted-color mb-4"><?php echo e($nlDesc); ?></p>
            <form action="#" method="POST" class="d-flex justify-content-center gap-3 flex-wrap">
                <?php echo csrf_field(); ?>
                <input type="email" name="email" class="form-input" style="max-width:380px;flex:1"
                    placeholder="<?php echo e($locale==='ar'?'أدخل بريدك الإلكتروني':'Enter your email'); ?>" required>
                <button type="submit" class="btn-donate"><?php echo e($locale==='ar'?'اشترك الآن':'Subscribe Now'); ?></button>
            </form>
        </div>
    </div>
</section>


<section class="main-section">
    <div class="container">
        <div class="donate overflow-hidden">
            <div class="content">
                <h2 class="main-title text-white mb-4"><?php echo e($locale==='ar'?'تبرّع الآن — أنقذ حياة':'Donate Now — Save Lives'); ?></h2>
                <p><?php echo e($locale==='ar'?'تبرّعك، مهما كان صغيرًا، يصنع تأثيرًا دائمًا.':'Your contribution, no matter how small, makes a lasting impact.'); ?></p>
                <div class="mt-4 holder">
                    <input type="text" name="amount" class="form-input" placeholder="<?php echo e($locale==='ar'?'ادخل المبلغ':'Enter amount'); ?>">
                    <button type="button" class="btn-donate"><?php echo e($locale==='ar'?'تبرع':'Donate'); ?></button>
                </div>
            </div>
            <img src="https://roaya-ansany.com/website/images/donate-child.svg" class="d-none d-lg-block" alt="donate">
        </div>
    </div>
</section>

<?php $__env->startPush('styles'); ?>
<style>
/* ===== WHY DONATE HEADER FIX ===== */
/* الـ .header الأصلي عنده flex + justify-content:space-between
   اللي بيكسر الـ text-align، فبنستخدم class جديد why-donate-header */
.why-donate-header {
    display: flex;
    flex-direction: column;
    align-items: flex-end; /* RTL default */
    width: 100%;
}
html[dir="ltr"] .why-donate-header {
    align-items: flex-start;
}
.why-donate-header h6 {
    display: block !important;
    width: 100% !important;
    font-weight: 600 !important;
}

/* ===== WHY ICON ===== */
.why-icon-circle {
    width:64px; height:64px; border-radius:50%;
    background: linear-gradient(135deg, color-mix(in srgb, <?php echo e($p); ?> 15%, transparent), color-mix(in srgb, <?php echo e($p); ?> 5%, transparent));
    display:flex; align-items:center; justify-content:center;
    margin:0 auto;
    border: 2px solid color-mix(in srgb, <?php echo e($p); ?> 30%, transparent);
}
.why-icon-circle i { color: color-mix(in srgb, <?php echo e($p); ?> 70%, #000); }
.why-icon-wrap { text-align:center; }
.partner-card { transition:transform 0.2s,box-shadow 0.2s; }
.partner-card:hover { transform:translateY(-4px);box-shadow:0 8px 24px rgba(0,0,0,0.1); }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Home\Desktop\roaya-ansany.com\roaya-ansany.com\resources\views/pages/home.blade.php ENDPATH**/ ?>