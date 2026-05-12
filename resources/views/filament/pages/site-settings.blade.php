@php use App\Models\Setting; @endphp
<x-filament-panels::page>
<form wire:submit="save" enctype="multipart/form-data">
<div class="space-y-3">

{{-- =================== هوية الموقع =================== --}}
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
                @php $logo = Setting::get('site_logo'); @endphp
                @if($logo)
                    <img src="{{ $logo }}" alt="Logo" class="h-16 mb-2 rounded">
                @else
                    <div class="h-16 mb-2 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded text-gray-400 text-xs">لا يوجد لوجو — سيستخدم الافتراضي</div>
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
                    <div class="h-10 mb-2 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded text-gray-400 text-xs">لا يوجد فافيكون</div>
                @endif
                <input type="file" wire:model="favicon_upload" accept="image/*,.ico"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
        </div>
    </div>
</div>

{{-- =================== روابط النافبار =================== --}}
<div x-data="{ open: true }" class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
        <span class="font-semibold text-base">🔗 روابط النافبار</span>
        <svg :class="open ? 'rotate-180' : ''"
            class="w-5 h-5 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">

        {{-- sticky toggle --}}
        <div
            x-data="{ val: @js(($this->data['navbar_sticky_only'] ?? '0') === '1') }"
            x-init="$watch('val', v => @this.set('data.navbar_sticky_only', v ? '1' : '0'))"
            class="flex items-center justify-between p-3 mb-4 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700">
            <div>
                <div class="font-medium text-sm">🔒 النافبار Sticky فقط (تظهر عند السكرول)</div>
                <div class="text-xs text-gray-400 mt-0.5">لو مفعّل — النافبار مخفية في أعلى الصفحة وتظهر بس لما يسكرول</div>
            </div>
            {{-- ✅ لا class ثابت لللون — كله عبر :class --}}
            <button type="button" @click="val = !val"
                :class="val ? 'bg-blue-600' : 'bg-gray-300 dark:bg-gray-600'"
                class="relative inline-flex h-6 w-11 flex-shrink-0 items-center rounded-full transition-colors duration-200 focus:outline-none">
                <span
                    :class="val ? 'translate-x-5' : 'translate-x-1'"
                    class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-200">
                </span>
            </button>
            <input type="hidden" wire:model="data.navbar_sticky_only" :value="val ? '1' : '0'">
        </div>

        {{-- روابط on/off --}}
        <div class="space-y-2">
        @foreach([
            ['key'=>'nav_show_home',      'label'=>'الرئيسية',        'icon'=>'🏠'],
            ['key'=>'nav_show_about',     'label'=>'من نحن',          'icon'=>'ℹ️'],
            ['key'=>'nav_show_campaigns', 'label'=>'الحملات',          'icon'=>'📢'],
            ['key'=>'nav_show_blogs',     'label'=>'المدونة',          'icon'=>'📝'],
            ['key'=>'nav_show_contact',   'label'=>'تواصل معنا',      'icon'=>'📞'],
            ['key'=>'nav_show_privacy',   'label'=>'سياسة الخصوصية', 'icon'=>'🔒'],
        ] as $link)
        <div
            x-data="{ val: @js(($this->data[$link['key']] ?? '1') === '1') }"
            x-init="$watch('val', v => @this.set('data.{{ $link['key'] }}', v ? '1' : '0'))"
            class="flex items-center justify-between p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="font-medium text-sm">{{ $link['icon'] }} {{ $link['label'] }}</div>
            {{-- ✅ لا class ثابت لللون — كله عبر :class --}}
            <button type="button" @click="val = !val"
                :class="val ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600'"
                class="relative inline-flex h-6 w-11 flex-shrink-0 items-center rounded-full transition-colors duration-200 focus:outline-none">
                <span
                    :class="val ? 'translate-x-5' : 'translate-x-1'"
                    class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-200">
                </span>
            </button>
            <input type="hidden" wire:model="data.{{ $link['key'] }}" :value="val ? '1' : '0'">
        </div>
        @endforeach
        </div>
    </div>
</div>

{{-- =================== الألوان الرئيسية =================== --}}
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
        @foreach([
            ['key'=>'color_primary',   'label'=>'اللون الأساسي',  'desc'=>'الأزرار، progress bar، الروابط النشطة'],
            ['key'=>'color_secondary', 'label'=>'اللون الثانوي',  'desc'=>'الغراديانت وبانر الهيرو'],
        ] as $c)
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
</div>

{{-- =================== ألوان النصوص =================== --}}
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
        @foreach([
            ['key'=>'color_text_dark',   'label'=>'نص غامق (العناوين)',    'desc'=>'العناوين الرئيسية h1 h2 h3'],
            ['key'=>'color_text_muted',  'label'=>'نص رمادي (الوصف)',      'desc'=>'الفقرات والوصف'],
            ['key'=>'color_text_label',  'label'=>'نص التسميات',           'desc'=>'#444C4E — لون التسميات والليبلات'],
            ['key'=>'color_placeholder', 'label'=>'لون البلسهولدر',        'desc'=>'نص حقول الإدخال قبل الكتابة'],
        ] as $c)
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
</div>

{{-- =================== ألوان الخلفيات =================== --}}
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
        @foreach([
            ['key'=>'color_bg_body',  'label'=>'خلفية الصفحة',         'desc'=>'لون خلفية body كاملاً'],
            ['key'=>'color_bg_light', 'label'=>'خلفية فاتحة (الأقسام)', 'desc'=>'أقسام support section وغيرها'],
            ['key'=>'color_bg_card',  'label'=>'خلفية الكروت',          'desc'=>'why-donate-card وكروت التبرع'],
        ] as $c)
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
</div>

{{-- =================== ألوان خاصة =================== --}}
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
        @foreach([
            ['key'=>'color_warning',     'label'=>'لون التحذير',         'desc'=>'برتقالي — رسائل التحذير'],
            ['key'=>'color_danger',      'label'=>'لون الخطر',           'desc'=>'أحمر — + وإشارات الخطر'],
            ['key'=>'color_step_active', 'label'=>'لون الخطوة النشطة',   'desc'=>'دائرة رقم الخطوة المحددة'],
        ] as $c)
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
</div>

{{-- =================== الفوتر =================== --}}
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

{{-- =================== التواصل =================== --}}
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

{{-- =================== حساب المدير =================== --}}
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

</div>{{-- end space-y-3 --}}

<div class="mt-6 flex justify-end">
    <x-filament::button type="submit" size="lg" color="success">
        💾 حفظ كل الإعدادات
    </x-filament::button>
</div>
</form>
</x-filament-panels::page>
