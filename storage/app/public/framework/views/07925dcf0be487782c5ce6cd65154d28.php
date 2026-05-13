<?php
    $locale  = app()->getLocale();
    $counter = $donationCounter ?? ['goal' => 0, 'raised' => 0, 'currency' => '$'];
    $goal    = (float)($counter['goal']   ?? 0);
    $raised  = (float)($counter['raised'] ?? 0);
    $curr    = $counter['currency'] ?? '$';
    $pct     = $goal > 0 ? min(100, round(($raised / $goal) * 100)) : 0;
    $remaining = max(0, $goal - $raised);
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($goal > 0): ?>
<section class="main-section donation-counter-section">
    <div class="container">
        <div class="donation-counter-box">
            
            <div class="text-center mb-5">
                <h6 class="main-color"><?php echo e($locale === 'ar' ? 'عداد التبرعات' : 'Donation Counter'); ?></h6>
                <h2 class="section-title">
                    <?php echo e($locale === 'ar' ? 'معاً نصنع الفرق' : 'Together We Make a Difference'); ?>

                </h2>
            </div>

            
            <div class="row text-center mb-4 g-4">
                <div class="col-md-4">
                    <div class="counter-stat-card">
                        <div class="counter-icon"><i class="fa-solid fa-circle-check"></i></div>
                        <div class="counter-number" data-target="<?php echo e($raised); ?>" data-currency="<?php echo e($curr); ?>"><?php echo e($curr); ?>0</div>
                        <div class="counter-label"><?php echo e($locale === 'ar' ? 'تم جمعه' : 'Raised'); ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="counter-stat-card featured">
                        <div class="counter-icon"><i class="fa-solid fa-bullseye"></i></div>
                        <div class="counter-number" data-target="<?php echo e($goal); ?>" data-currency="<?php echo e($curr); ?>"><?php echo e($curr); ?>0</div>
                        <div class="counter-label"><?php echo e($locale === 'ar' ? 'الهدف الكلي' : 'Total Goal'); ?></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="counter-stat-card">
                        <div class="counter-icon"><i class="fa-solid fa-hourglass-half"></i></div>
                        <div class="counter-number" data-target="<?php echo e($remaining); ?>" data-currency="<?php echo e($curr); ?>"><?php echo e($curr); ?>0</div>
                        <div class="counter-label"><?php echo e($locale === 'ar' ? 'المتبقي' : 'Remaining'); ?></div>
                    </div>
                </div>
            </div>

            
            <div class="counter-progress-wrap mb-2">
                <div class="counter-progress-bar">
                    <div class="counter-progress-fill" style="width: 0%" data-width="<?php echo e($pct); ?>"></div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span class="counter-pct-label main-color fw-bold">0%</span>
                    <span class="color-67" style="font-size:13px"><?php echo e($pct); ?>% <?php echo e($locale === 'ar' ? 'مكتمل' : 'Complete'); ?></span>
                </div>
            </div>

            
            <div class="text-center mt-5">
                <a href="<?php echo e(url($locale.'/donate')); ?>" class="btn-donate px-5">
                    <i class="fa-solid fa-heart me-2"></i>
                    <?php echo e($locale === 'ar' ? 'تبرع الآن واصنع الفرق' : 'Donate Now & Make a Difference'); ?>

                </a>
            </div>
        </div>
    </div>
</section>

<?php $__env->startPush('styles'); ?>
<style>
.donation-counter-section { background: linear-gradient(135deg, #f8fdf4 0%, #eef7e6 100%); }
.donation-counter-box { background: white; border-radius: 24px; padding: 50px 40px; box-shadow: 0 8px 40px rgba(90,158,47,0.12); }
.counter-stat-card { background: #f8fdf4; border-radius: 16px; padding: 30px 20px; border: 2px solid transparent; transition: all 0.3s; }
.counter-stat-card.featured { background: linear-gradient(135deg, #5a9e2f, #7bc244); border-color: #5a9e2f; }
.counter-stat-card.featured .counter-icon i,
.counter-stat-card.featured .counter-number,
.counter-stat-card.featured .counter-label { color: white !important; }
.counter-stat-card:hover { border-color: #5a9e2f; transform: translateY(-4px); box-shadow: 0 8px 24px rgba(90,158,47,0.15); }
.counter-icon { margin-bottom: 12px; }
.counter-icon i { font-size: 28px; color: #5a9e2f; }
.counter-number { font-size: 2rem; font-weight: 800; color: #5a9e2f; margin-bottom: 6px; direction: ltr; }
.counter-label { font-size: 14px; color: #888; font-weight: 500; }
.counter-progress-wrap { max-width: 700px; margin: 0 auto; }
.counter-progress-bar { background: #e8f4d9; border-radius: 50px; height: 14px; overflow: hidden; }
.counter-progress-fill { height: 100%; border-radius: 50px; background: linear-gradient(90deg, #5a9e2f, #9ccc65); transition: width 2s cubic-bezier(0.4,0,0.2,1); }
.counter-pct-label { font-size: 18px; transition: all 0.5s; }
@media(max-width:768px) { .donation-counter-box { padding: 30px 20px; } .counter-number { font-size: 1.5rem; } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function() {
    function formatNum(n, currency) {
        if (n >= 1000000) return currency + (n/1000000).toFixed(1) + 'M';
        if (n >= 1000)    return currency + (n/1000).toFixed(1)    + 'K';
        return currency + Math.round(n).toLocaleString();
    }

    function animateCounter(el, target, currency, duration) {
        let start = 0, startTime = null;
        function step(ts) {
            if (!startTime) startTime = ts;
            const progress = Math.min((ts - startTime) / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 4);
            start = ease * target;
            el.textContent = formatNum(start, currency);
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = formatNum(target, currency);
        }
        requestAnimationFrame(step);
    }

    function runCounters() {
        // Numbers
        document.querySelectorAll('.donation-counter-section .counter-number').forEach(el => {
            const target   = parseFloat(el.dataset.target) || 0;
            const currency = el.dataset.currency || '$';
            animateCounter(el, target, currency, 2000);
        });

        // Progress bar
        const fill = document.querySelector('.counter-progress-fill');
        const pctLabel = document.querySelector('.counter-pct-label');
        if (fill) {
            const targetWidth = parseFloat(fill.dataset.width) || 0;
            setTimeout(() => { fill.style.width = targetWidth + '%'; }, 100);
        }
        if (pctLabel) {
            const targetPct = parseFloat(document.querySelector('.counter-progress-fill')?.dataset.width) || 0;
            let cur = 0;
            const interval = setInterval(() => {
                cur = Math.min(cur + 1, targetPct);
                pctLabel.textContent = cur + '%';
                if (cur >= targetPct) clearInterval(interval);
            }, 2000 / Math.max(targetPct, 1));
        }
    }

    // Trigger on scroll into view
    const section = document.querySelector('.donation-counter-section');
    if (section) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { runCounters(); obs.disconnect(); }
            });
        }, { threshold: 0.3 });
        obs.observe(section);
    }
})();
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\Home\Desktop\roaya-ansany.com\roaya-ansany.com\resources\views/partials/donation-counter.blade.php ENDPATH**/ ?>