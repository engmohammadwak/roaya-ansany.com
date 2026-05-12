
<nav>
    <a href="<?php echo e(route('home', app()->getLocale())); ?>">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Setting::get('logo')): ?>
            <img src="<?php echo e(asset('storage/' . Setting::get('logo'))); ?>" alt="<?php echo e(Setting::get('site_name_' . app()->getLocale())); ?>">
        <?php else: ?>
            <?php echo e(Setting::get('site_name_' . app()->getLocale(), 'رؤية إنسانية')); ?>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </a>

    <ul>
        <li><a href="<?php echo e(route('home', app()->getLocale())); ?>"><?php echo e(__('nav.home')); ?></a></li>
        <li><a href="<?php echo e(route('about', app()->getLocale())); ?>"><?php echo e(__('nav.about')); ?></a></li>
        <li><a href="<?php echo e(route('blogs', app()->getLocale())); ?>"><?php echo e(__('nav.blogs')); ?></a></li>
        <li><a href="<?php echo e(route('campaigns', app()->getLocale())); ?>"><?php echo e(__('nav.campaigns')); ?></a></li>
        <li><a href="<?php echo e(route('donate', app()->getLocale())); ?>"><?php echo e(__('nav.donate')); ?></a></li>
        <li><a href="<?php echo e(route('contact', app()->getLocale())); ?>"><?php echo e(__('nav.contact')); ?></a></li>
    </ul>

    
    <div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->getLocale() == 'ar'): ?>
            <a href="<?php echo e(url('/en')); ?>">English</a>
        <?php else: ?>
            <a href="<?php echo e(url('/ar')); ?>">العربية</a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</nav>
<?php /**PATH C:\Users\Home\Desktop\roaya-ansany.com\roaya-ansany.com\resources\views/partials/navbar.blade.php ENDPATH**/ ?>