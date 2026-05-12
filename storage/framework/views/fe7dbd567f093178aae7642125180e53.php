<!DOCTYPE html>
<html
    dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>"
    lang="<?php echo e(app()->getLocale()); ?>"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', __('general.site_name')); ?> - <?php echo e(Setting::get('site_name_' . app()->getLocale())); ?></title>
    <link rel="icon" href="<?php echo e(asset('storage/' . Setting::get('favicon', ''))); ?>">

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->getLocale() == 'ar'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('website/libs/bootstrap/bootstrap.rtl.min.css')); ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('website/libs/bootstrap/bootstrap.min.css')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <link rel="stylesheet" href="<?php echo e(asset('website/libs/slimselect/slimselect.css')); ?>">

    
    <link rel="stylesheet" href="<?php echo e(asset('website/css/main.css')); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->getLocale() == 'ar'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('website/css/main.rtl.css')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="locale-<?php echo e(app()->getLocale()); ?>">

    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <script src="<?php echo e(asset('website/libs/bootstrap/bootstrap.bundle.min.js')); ?>"></script>

    
    <script src="<?php echo e(asset('website/libs/slimselect/slimselect.js')); ?>"></script>

    
    <script src="<?php echo e(asset('website/js/main.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Home\Desktop\roaya-ansany.com\roaya-ansany.com\resources\views/layouts/app.blade.php ENDPATH**/ ?>