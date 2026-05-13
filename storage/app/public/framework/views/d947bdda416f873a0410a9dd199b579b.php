<?php use App\Models\Setting; ?>
<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<form wire:submit="save" enctype="multipart/form-data">
<div class="space-y-3">


<div x-data="{ open: true }" class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
        <span class="font-semibold text-base">🌐 هوية الموقع</span>
        <svg :class="open ? 'rotate-180' : ''"
            class="w-5 h-5 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">اسم الموقع (عنوان التاب)</label>
                <input type="text" wire:model="data.site_name"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
            <div></div>
            <div>
                <label class="block text-sm font-medium mb-2">🎨 شعار الموقع (Logo)</label>
                <?php $logo = Setting::get('site_logo'); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logo): ?>
                    <img src="<?php echo e(asset('storage/' . $logo)); ?>" alt="Logo" class="h-16 mb-2 rounded">
                <?php else: ?>
                    <div class="h-16 mb-2 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded text-gray-400 text-xs">لا يوجد لوجو — سيستخدم الافتراضي</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <input type="file" wire:model="logo_upload" accept="image/*"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                <p class="text-xs text-gray-400 mt-1">ينصح باستخدام PNG بخلفية شفافة أو SVG</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">🔖 الفافيكون (Favicon)</label>
                <?php $fav = Setting::get('site_favicon'); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($fav): ?>
                    <img src="<?php echo e(asset('storage/' . $fav)); ?>" alt="Favicon" class="h-10 mb-2">
                <?php else: ?>
                    <div class="h-10 mb-2 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded text-gray-400 text-xs">لا يوجد فافيكون</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <input type="file" wire:model="favicon_upload" accept="image/*,.ico"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
        </div>
    </div>
</div>


<div x-data="{ open: true }" class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
        <span class="font-semibold text-base">🏠 الصفحة الرئيسية - Hero</span>
        <svg :class="open ? 'rotate-180' : ''"
            class="w-5 h-5 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">النص فوق الصورة (عربي)</label>
                <input type="text" wire:model="data.hero_label_ar"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800"
                    placeholder="تبرعك سينقذ الكثير من الأشخاص">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">النص فوق الصورة (إنجليزي)</label>
                <input type="text" wire:model="data.hero_label_en"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800"
                    placeholder="Your donation will save many lives">
            </div>
        </div>
        <div class="mt-4">
            <p class="text-sm font-medium mb-3">📐 موضع النص فوق الصورة</p>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Top (من الأعلى)</label>
                    <input type="text" wire:model="data.hero_label_top"
                        class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800 font-mono"
                        placeholder="12px">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Left (من اليسار)</label>
                    <input type="text" wire:model="data.hero_label_left"
                        class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800 font-mono"
                        placeholder="0 أو 351px">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Right (من اليمين)</label>
                    <input type="text" wire:model="data.hero_label_right"
                        class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800 font-mono"
                        placeholder="0">
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">💡 مثال: left=0 right=0 يمركز النص. left=351px يزيحه لليسار.</p>
        </div>
    </div>
</div>


<div
    x-data="{
        linksOn:  <?php echo \Illuminate\Support\Js::from(($this->data['navbar_links_enabled'] ?? '1') === '1')->toHtml() ?>,
        stickyOn: <?php echo \Illuminate\Support\Js::from(($this->data['navbar_sticky_only']  ?? '0') === '1')->toHtml() ?>
    }"
    x-init="
        $watch('linksOn',  v => window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('data.navbar_links_enabled', v ? '1' : '0'));
        $watch('stickyOn', v => window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('data.navbar_sticky_only',   v ? '1' : '0'));
    "
    class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

    <div class="px-5 py-4 bg-white dark:bg-gray-800 flex items-center justify-between">
        <span class="font-semibold text-base">🔗 روابط النافبار</span>
        <div class="flex items-center gap-3">
            <span x-text="linksOn ? 'مفعّل' : 'مخفي'"
                  :class="linksOn ? 'text-green-600 dark:text-green-400' : 'text-gray-400'"
                  class="text-sm font-medium"></span>
            <button type="button" @click="linksOn = !linksOn"
                :class="linksOn ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600'"
                class="relative inline-flex h-7 w-14 flex-shrink-0 items-center rounded-full transition-colors duration-300 focus:outline-none">
                <span
                    :class="linksOn ? 'translate-x-7' : 'translate-x-1'"
                    class="inline-block h-5 w-5 transform rounded-full bg-white shadow-md transition-transform duration-300">
                </span>
            </button>
        </div>
    </div>

    <input type="hidden" wire:model="data.navbar_links_enabled" :value="linksOn  ? '1' : '0'">
    <input type="hidden" wire:model="data.navbar_sticky_only"   :value="stickyOn ? '1' : '0'">

    <div x-show="linksOn" x-transition
         class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 space-y-3">
        <p class="text-xs text-gray-400">✅ الروابط التالية ستظهر في النافبار على جميع الصفحات:</p>
        <div class="flex flex-wrap gap-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['🏠 الرئيسية','ℹ️ من نحن','📢 الحملات','📝 المدونة','📞 تواصل معنا','🔒 سياسة الخصوصية']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-700">
                <?php echo e($lbl); ?>

            </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="flex items-center justify-between p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700">
            <div>
                <div class="font-medium text-sm">🔒 Sticky فقط (تظهر عند السكرول)</div>
                <div class="text-xs text-gray-400 mt-0.5">النافبار مخفية في أعلى الصفحة وتظهر لما يسكرول</div>
            </div>
            <div class="flex items-center gap-2">
                <span x-text="stickyOn ? 'ON' : 'OFF'"
                      :class="stickyOn ? 'text-blue-600' : 'text-gray-400'"
                      class="text-xs font-bold"></span>
                <button type="button" @click="stickyOn = !stickyOn"
                    :class="stickyOn ? 'bg-blue-600' : 'bg-gray-300 dark:bg-gray-600'"
                    class="relative inline-flex h-7 w-14 flex-shrink-0 items-center rounded-full transition-colors duration-300 focus:outline-none">
                    <span
                        :class="stickyOn ? 'translate-x-7' : 'translate-x-1'"
                        class="inline-block h-5 w-5 transform rounded-full bg-white shadow-md transition-transform duration-300">
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>


<div x-data="{ open: true }" class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
        <span class="font-semibold text-base">🎨 الألوان الرئيسية</span>
        <svg :class="open ? 'rotate-180' : ''"
            class="w-5 h-5 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 space-y-3">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
            ['key'=>'color_primary',   'label'=>'اللون الأساسي',  'desc'=>'الأزرار، progress bar، الروابط النشطة'],
            ['key'=>'color_secondary', 'label'=>'اللون الثانوي',  'desc'=>'الغراديانت وبانر الهيرو'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <input type="color" wire:model="data.<?php echo e($c['key']); ?>" class="w-14 h-10 rounded border cursor-pointer flex-shrink-0">
            <div class="flex-1">
                <div class="font-medium text-sm"><?php echo e($c['label']); ?></div>
                <div class="text-xs text-gray-400"><?php echo e($c['desc']); ?></div>
            </div>
            <input type="text" wire:model="data.<?php echo e($c['key']); ?>" placeholder="#000000"
                class="fi-input w-32 rounded-lg border border-gray-300 dark:border-gray-600 px-2 py-1 text-sm bg-white dark:bg-gray-800 font-mono">
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>


<div x-data="{ open: false }" class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
        <span class="font-semibold text-base">🔤 ألوان النصوص</span>
        <svg :class="open ? 'rotate-180' : ''"
            class="w-5 h-5 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 space-y-3">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
            ['key'=>'color_text_dark',   'label'=>'نص غامق (العناوين)',    'desc'=>'العناوين الرئيسية h1 h2 h3'],
            ['key'=>'color_text_muted',  'label'=>'نص رمادي (الوصف)',      'desc'=>'الفقرات والوصف'],
            ['key'=>'color_text_label',  'label'=>'نص التسميات',           'desc'=>'#444C4E — لون التسميات والليبلات'],
            ['key'=>'color_placeholder', 'label'=>'لون البلسهولدر',        'desc'=>'نص حقول الإدخال قبل الكتابة'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <input type="color" wire:model="data.<?php echo e($c['key']); ?>" class="w-14 h-10 rounded border cursor-pointer flex-shrink-0">
            <div class="flex-1">
                <div class="font-medium text-sm"><?php echo e($c['label']); ?></div>
                <div class="text-xs text-gray-400"><?php echo e($c['desc']); ?></div>
            </div>
            <input type="text" wire:model="data.<?php echo e($c['key']); ?>" placeholder="#000000"
                class="fi-input w-32 rounded-lg border border-gray-300 dark:border-gray-600 px-2 py-1 text-sm bg-white dark:bg-gray-800 font-mono">
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>


<div x-data="{ open: false }" class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
        <span class="font-semibold text-base">🖥️ ألوان الخلفيات</span>
        <svg :class="open ? 'rotate-180' : ''"
            class="w-5 h-5 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 space-y-3">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
            ['key'=>'color_bg_body',  'label'=>'خلفية الصفحة',         'desc'=>'لون خلفية body كاملاً'],
            ['key'=>'color_bg_light', 'label'=>'خلفية فاتحة (الأقسام)', 'desc'=>'أقسام support section وغيرها'],
            ['key'=>'color_bg_card',  'label'=>'خلفية الكروت',          'desc'=>'why-donate-card وكروت التبرع'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <input type="color" wire:model="data.<?php echo e($c['key']); ?>" class="w-14 h-10 rounded border cursor-pointer flex-shrink-0">
            <div class="flex-1">
                <div class="font-medium text-sm"><?php echo e($c['label']); ?></div>
                <div class="text-xs text-gray-400"><?php echo e($c['desc']); ?></div>
            </div>
            <input type="text" wire:model="data.<?php echo e($c['key']); ?>" placeholder="#ffffff"
                class="fi-input w-32 rounded-lg border border-gray-300 dark:border-gray-600 px-2 py-1 text-sm bg-white dark:bg-gray-800 font-mono">
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>


<div x-data="{ open: false }" class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
        <span class="font-semibold text-base">⚠️ ألوان خاصة</span>
        <svg :class="open ? 'rotate-180' : ''"
            class="w-5 h-5 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 space-y-3">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
            ['key'=>'color_warning',     'label'=>'لون التحذير',         'desc'=>'برتقالي — رسائل التحذير'],
            ['key'=>'color_danger',      'label'=>'لون الخطر',           'desc'=>'أحمر — + وإشارات الخطر'],
            ['key'=>'color_step_active', 'label'=>'لون الخطوة النشطة',   'desc'=>'دائرة رقم الخطوة المحددة'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <input type="color" wire:model="data.<?php echo e($c['key']); ?>" class="w-14 h-10 rounded border cursor-pointer flex-shrink-0">
            <div class="flex-1">
                <div class="font-medium text-sm"><?php echo e($c['label']); ?></div>
                <div class="text-xs text-gray-400"><?php echo e($c['desc']); ?></div>
            </div>
            <input type="text" wire:model="data.<?php echo e($c['key']); ?>" placeholder="#000000"
                class="fi-input w-32 rounded-lg border border-gray-300 dark:border-gray-600 px-2 py-1 text-sm bg-white dark:bg-gray-800 font-mono">
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>


<div x-data="{ open: false }" class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
        <span class="font-semibold text-base">📌 محتوى الفوتر</span>
        <svg :class="open ? 'rotate-180' : ''"
            class="w-5 h-5 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">وصف الفوتر (عربي)</label>
                <textarea wire:model="data.footer_description_ar" rows="3"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">وصف الفوتر (إنجليزي)</label>
                <textarea wire:model="data.footer_description_en" rows="3"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">نص الحقوق (عربي)</label>
                <input type="text" wire:model="data.footer_copyright_ar"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">نص الحقوق (إنجليزي)</label>
                <input type="text" wire:model="data.footer_copyright_en"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
        </div>
    </div>
</div>


<div x-data="{ open: false }" class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
        <span class="font-semibold text-base">📞 معلومات التواصل</span>
        <svg :class="open ? 'rotate-180' : ''"
            class="w-5 h-5 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">رقم الهاتف</label>
                <input type="text" wire:model="data.contact_phone"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">البريد الإلكتروني</label>
                <input type="email" wire:model="data.contact_email"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">📲 رقم الواتساب</label>
                <input type="text" wire:model="data.whatsapp_number" placeholder="905398863777"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                <p class="text-xs text-gray-400 mt-1">بدون + مثال: 905398863777</p>
            </div>
        </div>
    </div>
</div>


<div x-data="{ open: false }" class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
        <span class="font-semibold text-base">🔐 حساب المدير</span>
        <svg :class="open ? 'rotate-180' : ''"
            class="w-5 h-5 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">اسم المستخدم</label>
                <input type="text" wire:model="data.admin_username"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">البريد الإلكتروني</label>
                <input type="email" wire:model="data.admin_email"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">كلمة المرور الجديدة (فارغة = بدون تغيير)</label>
                <input type="password" wire:model="data.admin_password" placeholder="••••••••"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
        </div>
    </div>
</div>

</div>

<div class="mt-6 flex justify-end">
    <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['type' => 'submit','size' => 'lg','color' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','size' => 'lg','color' => 'success']); ?>
        💾 حفظ كل الإعدادات
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
</div>
</form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Home\Desktop\roaya-ansany.com\roaya-ansany.com\resources\views/filament/pages/site-settings.blade.php ENDPATH**/ ?>