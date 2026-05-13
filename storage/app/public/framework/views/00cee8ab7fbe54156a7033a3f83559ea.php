<?php
    $locale      = app()->getLocale();
    $otherLocale = $locale === 'ar' ? 'en' : 'ar';
    $siteLogo    = App\Models\Setting::get('site_logo');
    $siteName    = App\Models\Setting::get('site_name', 'رؤيا');

    // روابط النافبار — on/off من الإعدادات
    $navLinks = [
        'home'    => ['ar' => 'الرئيسية',       'en' => 'Home',           'path' => $locale],
        'about'   => ['ar' => 'من نحن',           'en' => 'About Us',       'path' => $locale.'/about'],
        'campaigns'=>['ar' => 'الحملات',          'en' => 'Campaigns',      'path' => $locale.'/campaigns'],
        'blogs'   => ['ar' => 'المدونة',          'en' => 'Blog',           'path' => $locale.'/blogs'],
        'contact' => ['ar' => 'تواصل معنا',       'en' => 'Contact Us',     'path' => $locale.'/contact'],
        'privacy' => ['ar' => 'سياسة الخصوصية',  'en' => 'Privacy Policy', 'path' => $locale.'/privacy-policy'],
    ];
?>

<header>
<nav id="main-navbar"
     class="navbar navbar-expand-lg py-2 fixed-top main-navbar"
     aria-label="Main Navigation">
    <div class="container position-relative">

        
        <a class="navbar-brand d-flex align-items-center" href="<?php echo e(url($locale)); ?>">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteLogo): ?>
                <img src="<?php echo e(asset('storage/' . $siteLogo)); ?>" alt="<?php echo e($siteName); ?>" class="me-2" style="max-height:50px;">
            <?php else: ?>
                <img src="https://roaya-ansany.com/website/images/logo.svg" alt="<?php echo e($siteName); ?>" class="me-2">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </a>

        <div class="d-flex align-items-center">
            <div class="language-switcher mobile me-3">
                <a href="<?php echo e(url($otherLocale)); ?>"><?php echo e($locale === 'ar' ? 'English' : 'العربية'); ?></a>
            </div>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav links-holder mx-auto mb-2 mb-lg-0">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $navLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(App\Models\Setting::get('nav_show_'.$key, '1') === '1'): ?>
                    <li class="nav-item me-4">
                        <a class="nav-link <?php echo e(request()->is($link['path']) || request()->is($link['path'].'/*') ? 'active' : ''); ?>"
                           href="<?php echo e(url($link['path'])); ?>"><?php echo e($link[$locale]); ?></a>
                    </li>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
            <div class="d-flex justify-content-center align-items-center">
                <div class="language-switcher me-3">
                    <a href="<?php echo e(url($otherLocale)); ?>" class="lang-value"><?php echo e($locale === 'ar' ? 'English' : 'العربية'); ?></a>
                </div>
                <a href="<?php echo e(url($locale.'/donate')); ?>" class="btn-donate"><?php echo e($locale === 'ar' ? 'تبرع' : 'Donate'); ?></a>
            </div>
        </div>

    </div>
</nav>
</header>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(App\Models\Setting::get('navbar_sticky_only', '0') === '1'): ?>
<style>
    #main-navbar {
        transform: translateY(-100%);
        transition: transform 0.35s ease, background 0.3s ease, box-shadow 0.3s ease;
        background: transparent !important;
        box-shadow: none !important;
    }
    #main-navbar.is-sticky {
        transform: translateY(0);
        background: var(--color-bg-body, #fff) !important;
        box-shadow: 0 2px 16px rgba(0,0,0,0.10) !important;
    }
</style>
<script>
(function(){
    var nav = document.getElementById('main-navbar');
    window.addEventListener('scroll', function(){
        if(window.scrollY > 60){
            nav.classList.add('is-sticky');
        } else {
            nav.classList.remove('is-sticky');
        }
    }, { passive: true });
})();
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\Home\Desktop\roaya-ansany.com\roaya-ansany.com\resources\views/partials/navbar.blade.php ENDPATH**/ ?>