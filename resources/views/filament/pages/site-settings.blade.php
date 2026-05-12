<x-filament-panels::page>
@php use App\Models\Setting; @endphp
<form wire:submit="save" enctype="multipart/form-data">
<div class="space-y-6">

    {{-- الهوية --}}
    <x-filament::section heading="🌐 هوية الموقع">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">اسم الموقع (عنوان التاب)</label>
                <input type="text" wire:model="data.site_name"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
            <div></div>
            <div>
                <label class="block text-sm font-medium mb-2">🎨 شعار الموقع (Logo)</label>
                @php $logo = Setting::get('site_logo'); @endphp
                @if($logo)
                    <img src="{{ $logo }}" alt="Logo" class="h-16 mb-2 rounded">
                @else
                    <div class="h-16 mb-2 flex items-center justify-center bg-gray-100 rounded text-gray-400 text-xs">لا يوجد لوجو — سيستخدم الافتراضي</div>
                @endif
                <input type="file" wire:model="logo_upload" accept="image/*"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                <p class="text-xs text-gray-400 mt-1">ينصح باستخدام PNG بخلفية شفافة أو SVG</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">🔖 الفافيكون (Favicon)</label>
                @php $fav = Setting::get('site_favicon'); @endphp
                @if($fav)
                    <img src="{{ $fav }}" alt="Favicon" class="h-10 mb-2">
                @else
                    <div class="h-10 mb-2 flex items-center justify-center bg-gray-100 rounded text-gray-400 text-xs">لا يوجد فافيكون</div>
                @endif
                <input type="file" wire:model="favicon_upload" accept="image/*,.ico"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
        </div>
    </x-filament::section>

    {{-- ألوان رئيسية --}}
    <x-filament::section heading="🎨 الألوان الرئيسية">
        @php
        $mainColors = [
            ['key'=>'color_primary',   'label'=>'اللون الأساسي',  'desc'=>'الأزرار، progress bar، الروابط النشطة'],
            ['key'=>'color_secondary', 'label'=>'اللون الثانوي',  'desc'=>'الغراديانت وبانر الهيرو'],
        ];
        @endphp
        <div class="space-y-3">
        @foreach($mainColors as $c)
        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <input type="color" wire:model="data.{{ $c['key'] }}" class="w-14 h-10 rounded border cursor-pointer flex-shrink-0">
            <div class="flex-1">
                <div class="font-medium text-sm">{{ $c['label'] }}</div>
                <div class="text-xs text-gray-400">{{ $c['desc'] }}</div>
            </div>
            <input type="text" wire:model="data.{{ $c['key'] }}" placeholder="#000000"
                class="fi-input w-32 rounded-lg border border-gray-300 dark:border-gray-600 px-2 py-1 text-sm bg-white dark:bg-gray-800 font-mono">
        </div>
        @endforeach
        </div>
    </x-filament::section>

    {{-- ألوان النصوص --}}
    <x-filament::section heading="🔤 ألوان النصوص">
        @php
        $textColors = [
            ['key'=>'color_text_dark',   'label'=>'نص غامق (العناوين)',    'desc'=>'العناوين الرئيسية h1 h2 h3'],
            ['key'=>'color_text_muted',  'label'=>'نص رمادي (الوصف)',      'desc'=>'الفقرات والوصف'],
            ['key'=>'color_text_label',  'label'=>'نص التسميات',           'desc'=>'#444C4E — لون التسميات والليبلات'],
            ['key'=>'color_placeholder', 'label'=>'لون البلسهولدر',         'desc'=>'نص حقول الإدخال قبل الكتابة'],
        ];
        @endphp
        <div class="space-y-3">
        @foreach($textColors as $c)
        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <input type="color" wire:model="data.{{ $c['key'] }}" class="w-14 h-10 rounded border cursor-pointer flex-shrink-0">
            <div class="flex-1">
                <div class="font-medium text-sm">{{ $c['label'] }}</div>
                <div class="text-xs text-gray-400">{{ $c['desc'] }}</div>
            </div>
            <input type="text" wire:model="data.{{ $c['key'] }}" placeholder="#000000"
                class="fi-input w-32 rounded-lg border border-gray-300 dark:border-gray-600 px-2 py-1 text-sm bg-white dark:bg-gray-800 font-mono">
        </div>
        @endforeach
        </div>
    </x-filament::section>

    {{-- الخلفيات --}}
    <x-filament::section heading="🖥️ ألوان الخلفيات">
        @php
        $bgColors = [
            ['key'=>'color_bg_body',  'label'=>'خلفية الصفحة',         'desc'=>'لون خلفية body كاملاً'],
            ['key'=>'color_bg_light', 'label'=>'خلفية فاتحة (الأقسام)', 'desc'=>'أقسام support section وغيرها'],
            ['key'=>'color_bg_card',  'label'=>'خلفية الكروت',          'desc'=>'why-donate-card وكروت التبرع'],
        ];
        @endphp
        <div class="space-y-3">
        @foreach($bgColors as $c)
        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <input type="color" wire:model="data.{{ $c['key'] }}" class="w-14 h-10 rounded border cursor-pointer flex-shrink-0">
            <div class="flex-1">
                <div class="font-medium text-sm">{{ $c['label'] }}</div>
                <div class="text-xs text-gray-400">{{ $c['desc'] }}</div>
            </div>
            <input type="text" wire:model="data.{{ $c['key'] }}" placeholder="#ffffff"
                class="fi-input w-32 rounded-lg border border-gray-300 dark:border-gray-600 px-2 py-1 text-sm bg-white dark:bg-gray-800 font-mono">
        </div>
        @endforeach
        </div>
    </x-filament::section>

    {{-- ألوان خاصة --}}
    <x-filament::section heading="⚠️ ألوان خاصة">
        @php
        $specialColors = [
            ['key'=>'color_warning',     'label'=>'لون التحذير',          'desc'=>'برتقالي — رسائل التحذير'],
            ['key'=>'color_danger',      'label'=>'لون الخطر',            'desc'=>'أحمر — + وإشارات الخطر'],
            ['key'=>'color_step_active', 'label'=>'لون الخطوة النشطة',    'desc'=>'دائرة رقم الخطوة المحددة'],
        ];
        @endphp
        <div class="space-y-3">
        @foreach($specialColors as $c)
        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <input type="color" wire:model="data.{{ $c['key'] }}" class="w-14 h-10 rounded border cursor-pointer flex-shrink-0">
            <div class="flex-1">
                <div class="font-medium text-sm">{{ $c['label'] }}</div>
                <div class="text-xs text-gray-400">{{ $c['desc'] }}</div>
            </div>
            <input type="text" wire:model="data.{{ $c['key'] }}" placeholder="#000000"
                class="fi-input w-32 rounded-lg border border-gray-300 dark:border-gray-600 px-2 py-1 text-sm bg-white dark:bg-gray-800 font-mono">
        </div>
        @endforeach
        </div>
    </x-filament::section>

    {{-- الفوتر --}}
    <x-filament::section heading="📌 محتوى الفوتر">
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
    </x-filament::section>

    {{-- التواصل --}}
    <x-filament::section heading="📞 معلومات التواصل">
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
    </x-filament::section>

    {{-- حساب المدير --}}
    <x-filament::section heading="🔐 حساب المدير">
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
    </x-filament::section>

</div>
<div class="mt-6 flex justify-end">
    <x-filament::button type="submit" size="lg" color="success">
        💾 حفظ كل الإعدادات
    </x-filament::button>
</div>
</form>
</x-filament-panels::page>
