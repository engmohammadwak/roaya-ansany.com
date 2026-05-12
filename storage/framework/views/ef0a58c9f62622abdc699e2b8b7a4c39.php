
<?php $__env->startSection('title', __('nav.home')); ?>

<?php $__env->startSection('content'); ?>
    
    <section class="hero">
        <h1><?php echo e(Setting::get('hero_title_' . app()->getLocale())); ?></h1>
        <p><?php echo e(Setting::get('hero_subtitle_' . app()->getLocale())); ?></p>
        <a href="<?php echo e(route('donate', app()->getLocale())); ?>"><?php echo e(__('general.donate_now')); ?></a>
    </section>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($campaigns->count()): ?>
    <section class="campaigns">
        <h2><?php echo e(__('general.latest_campaigns')); ?></h2>
        <div class="campaigns-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="campaign-card">
                <img src="<?php echo e($campaign->image_url); ?>" alt="<?php echo e($campaign->title); ?>">
                <h3><?php echo e($campaign->title); ?></h3>
                <p><?php echo e(Str::limit($campaign->description, 100)); ?></p>
                <div class="progress">
                    <div class="progress-bar" style="width: <?php echo e($campaign->progress_percentage); ?>%"></div>
                </div>
                <span><?php echo e($campaign->progress_percentage); ?>%</span>
                <a href="<?php echo e(route('campaigns.show', [app()->getLocale(), $campaign->id])); ?>"><?php echo e(__('general.read_more')); ?></a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($blogs->count()): ?>
    <section class="blogs">
        <h2><?php echo e(__('general.latest_blogs')); ?></h2>
        <div class="blogs-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="blog-card">
                <img src="<?php echo e($blog->image_url); ?>" alt="<?php echo e($blog->title); ?>">
                <h3><?php echo e($blog->title); ?></h3>
                <p><?php echo e($blog->excerpt); ?></p>
                <a href="<?php echo e(route('blogs.show', [app()->getLocale(), $blog->slug])); ?>"><?php echo e(__('general.read_more')); ?></a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Home\Desktop\roaya-ansany.com\roaya-ansany.com\resources\views/pages/home.blade.php ENDPATH**/ ?>