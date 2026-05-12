
<footer>
    <p><?php echo e(Setting::get('site_name_' . app()->getLocale())); ?> &copy; <?php echo e(date('Y')); ?></p>

    <div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Setting::get('facebook_url')): ?>
            <a href="<?php echo e(Setting::get('facebook_url')); ?>" target="_blank">Facebook</a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Setting::get('twitter_url')): ?>
            <a href="<?php echo e(Setting::get('twitter_url')); ?>" target="_blank">Twitter</a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Setting::get('instagram_url')): ?>
            <a href="<?php echo e(Setting::get('instagram_url')); ?>" target="_blank">Instagram</a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Setting::get('youtube_url')): ?>
            <a href="<?php echo e(Setting::get('youtube_url')); ?>" target="_blank">YouTube</a>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div>
        <a href="<?php echo e(route('privacy', app()->getLocale())); ?>"><?php echo e(__('nav.privacy')); ?></a>
        <a href="<?php echo e(route('terms', app()->getLocale())); ?>"><?php echo e(__('nav.terms')); ?></a>
    </div>
</footer>
<?php /**PATH C:\Users\Home\Desktop\roaya-ansany.com\roaya-ansany.com\resources\views/partials/footer.blade.php ENDPATH**/ ?>