<?php
    $locale      = app()->getLocale();
    $siteLogo    = App\Models\Setting::get('site_logo');
    $siteName    = App\Models\Setting::get('site_name', 'رؤيا');
    $footerDescAr = App\Models\Setting::get('footer_description_ar', 'رؤيا هي منصة عطاء مخصصة للأشخاص الذين يهتمون بالأثر الحقيقي لعطائهم.');
    $footerDescEn = App\Models\Setting::get('footer_description_en', 'Roaya is a giving platform dedicated to people who care about the real impact of their giving.');
    $copyrightAr  = App\Models\Setting::get('footer_copyright_ar', 'جميع الحقوق محفوظة © مؤسسة رؤيا الإنسانية ' . date('Y'));
    $copyrightEn  = App\Models\Setting::get('footer_copyright_en', 'All Rights Reserved © Roaya Insanya ' . date('Y'));
    $phone        = App\Models\Setting::get('contact_phone', '+905398863777');
    $email        = App\Models\Setting::get('contact_email', 'roaya.ansany@gmail.com');
?>
<footer class="footer mt-5 border-top pt-3">
    <div class="container overflow-hidden">
        <div class="row gy-4">
            <div class="col-md-4">
                <a href="<?php echo e(url($locale)); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteLogo): ?>
                        <img src="<?php echo e($siteLogo); ?>" alt="<?php echo e($siteName); ?>" class="footer-logo mb-2" style="max-height:80px;">
                    <?php else: ?>
                        <img width="134" height="113" src="https://roaya-ansany.com/website/images/logo.svg" alt="<?php echo e($siteName); ?>" class="footer-logo mb-2">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </a>
                <p class="footer-about muted-color">
                    <?php echo e($locale === 'ar' ? $footerDescAr : $footerDescEn); ?>

                </p>
                <div class="social-icons mt-4">
                    <a href="https://www.facebook.com/profile.php?id=61568018236938" target="_blank">
                        <img width="24" height="24" src="https://roaya-ansany.com/website/images/facebook.svg" alt="facebook">
                    </a>
                    <a href="https://www.instagram.com/roaya.ansany/" target="_blank">
                        <img width="24" height="24" src="https://roaya-ansany.com/website/images/Instagram.svg" alt="Instagram">
                    </a>
                    <a href="https://x.com/RoayaAnsany2025" target="_blank">
                        <img width="24" height="24" src="https://roaya-ansany.com/website/images/xtwitter.png" alt="x">
                    </a>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-6 col-md-4 mt-5">
                        <h5><?php echo e($locale === 'ar' ? 'روابط سريعة' : 'Quick Links'); ?></h5>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo e(url($locale)); ?>"><?php echo e($locale === 'ar' ? 'الرئيسية' : 'Home'); ?></a></li>
                            <li><a href="<?php echo e(url($locale.'/about')); ?>"><?php echo e($locale === 'ar' ? 'من نحن' : 'About Us'); ?></a></li>
                            <li><a href="<?php echo e(url($locale.'/blogs')); ?>"><?php echo e($locale === 'ar' ? 'المدونة' : 'Blog'); ?></a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-4 mt-5">
                        <h5><?php echo e($locale === 'ar' ? 'المصادر' : 'Resources'); ?></h5>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo e(url($locale.'/contact')); ?>"><?php echo e($locale === 'ar' ? 'تواصل معنا' : 'Contact Us'); ?></a></li>
                            <li><a href="<?php echo e(url($locale.'/privacy-policy')); ?>"><?php echo e($locale === 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy'); ?></a></li>
                            <li><a href="<?php echo e(url($locale.'/terms-and-conditions')); ?>"><?php echo e($locale === 'ar' ? 'القواعد والأحكام' : 'Terms & Conditions'); ?></a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-4 mt-5">
                        <h5><?php echo e($locale === 'ar' ? 'تواصل معنا' : 'Contact Us'); ?></h5>
                        <p class="mb-3">
                            <img class="me-3" src="https://roaya-ansany.com/website/images/phone.svg" alt="phone">
                            <span class="muted-color" dir="ltr">
                                <a class="link-offset-2 link-underline link-underline-opacity-0 link-secondary" href="tel:<?php echo e($phone); ?>"><?php echo e($phone); ?></a>
                            </span>
                        </p>
                        <p class="mb-3">
                            <img class="me-3" src="https://roaya-ansany.com/website/images/message.svg" alt="message">
                            <span class="muted-color">
                                <a class="link-offset-2 link-underline link-underline-opacity-0 link-secondary" href="mailto:<?php echo e($email); ?>"><?php echo e($email); ?></a>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom mt-4 py-3 border-top">
        <div class="container">
            <p class="m-0 text-center text-lg-start muted-color">
                <?php echo e($locale === 'ar' ? $copyrightAr : $copyrightEn); ?>

            </p>
        </div>
    </div>
</footer>
<?php /**PATH C:\Users\Home\Desktop\roaya-ansany.com\roaya-ansany.com\resources\views/partials/footer.blade.php ENDPATH**/ ?>