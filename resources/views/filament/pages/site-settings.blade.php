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
            {{-- وضع الصيانة --}}
            <div
                x-data="{ on: @js(($this->data['maintenance_mode'] ?? '0') === '1') }"
                x-init="$watch('on', v => @this.set('data.maintenance_mode', v ? '1' : '0'))"
                class="rounded-lg border border-amber-200 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/20 p-4 flex items-center justify-between gap-4">
                <div>
                    <label class="block text-sm font-bold mb-1">🔧 وضع الصيانة</label>
                    <p class="text-xs text-gray-500">عند التفعيل يرى الزوار صفحة صيانة مع بيانات التواصل، بينما لوحة الإدارة تبقى متاحة.</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span x-text="on ? 'مفعّل' : 'معطّل'" :class="on ? 'text-amber-600 dark:text-amber-400' : 'text-gray-400'" class="text-sm font-medium"></span>
                    <button type="button" @click="on = !on"
                        :class="on ? 'bg-amber-500' : 'bg-gray-300 dark:bg-gray-600'"
                        class="relative inline-flex h-7 w-14 flex-shrink-0 items-center rounded-full transition-colors duration-300 focus:outline-none">
                        <span :class="on ? 'translate-x-7' : 'translate-x-1'" class="inline-block h-5 w-5 transform rounded-full bg-white shadow-md transition-transform duration-300"></span>
                    </button>
                </div>
                <input type="hidden" wire:model="data.maintenance_mode" :value="on ? '1' : '0'">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">🎨 شعار الموقع (Logo)</label>
                @php $logo = Setting::get('site_logo'); @endphp
                @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-16 mb-2 rounded">
                @else
                    <div class="h-16 mb-2 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded text-gray-400 text-xs">لا يوجد لوجو</div>
                @endif
                <input type="file" wire:model="logo_upload" accept="image/*"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                <p class="text-xs text-gray-400 mt-1">ينصح باستخدام PNG بخلفية شفافة أو SVG</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">🔖 الفافيكون (Favicon)</label>
                @php $fav = Setting::get('site_favicon'); @endphp
                @if($fav)
                    <img src="{{ asset('storage/' . $fav) }}" alt="Favicon" class="h-10 mb-2">
                @else
                    <div class="h-10 mb-2 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded text-gray-400 text-xs">لا يوجد فافيكون</div>
                @endif
                <input type="file" wire:model="favicon_upload" accept="image/*,.ico"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
        </div>
    </div>
</div>

{{-- =================== الصفحة الرئيسية - Hero =================== --}}
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
                    <label class="block text-xs text-gray-500 mb-1">Top</label>
                    <input type="text" wire:model="data.hero_label_top"
                        class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800 font-mono" placeholder="12px">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Left</label>
                    <input type="text" wire:model="data.hero_label_left"
                        class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800 font-mono" placeholder="0">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Right</label>
                    <input type="text" wire:model="data.hero_label_right"
                        class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800 font-mono" placeholder="0">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =================== روابط النافبار =================== --}}
<div
    x-data="{
        linksOn:  @js(($this->data['navbar_links_enabled'] ?? '1') === '1'),
        stickyOn: @js(($this->data['navbar_sticky_only']  ?? '0') === '1')
    }"
    x-init="
        $watch('linksOn',  v => @this.set('data.navbar_links_enabled', v ? '1' : '0'));
        $watch('stickyOn', v => @this.set('data.navbar_sticky_only',   v ? '1' : '0'));
    "
    class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-5 py-4 bg-white dark:bg-gray-800 flex items-center justify-between">
        <span class="font-semibold text-base">🔗 روابط النافبار</span>
        <div class="flex items-center gap-3">
            <span x-text="linksOn ? 'مفعّل' : 'مخفي'" :class="linksOn ? 'text-green-600 dark:text-green-400' : 'text-gray-400'" class="text-sm font-medium"></span>
            <button type="button" @click="linksOn = !linksOn"
                :class="linksOn ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600'"
                class="relative inline-flex h-7 w-14 flex-shrink-0 items-center rounded-full transition-colors duration-300 focus:outline-none">
                <span :class="linksOn ? 'translate-x-7' : 'translate-x-1'" class="inline-block h-5 w-5 transform rounded-full bg-white shadow-md transition-transform duration-300"></span>
            </button>
        </div>
    </div>
    <input type="hidden" wire:model="data.navbar_links_enabled" :value="linksOn ? '1' : '0'">
    <input type="hidden" wire:model="data.navbar_sticky_only"   :value="stickyOn ? '1' : '0'">
    <div x-show="linksOn" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 space-y-3">
        <div class="flex flex-wrap gap-2">
            @foreach(['🏠 الرئيسية','ℹ️ من نحن','📢 الحملات','📝 المدونة','📞 تواصل معنا','🔒 سياسة الخصوصية'] as $lbl)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-700">{{ $lbl }}</span>
            @endforeach
        </div>
        <div class="flex items-center justify-between p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700">
            <div>
                <div class="font-medium text-sm">🔒 Sticky فقط</div>
                <div class="text-xs text-gray-400 mt-0.5">تظهر عند السكرول فقط</div>
            </div>
            <div class="flex items-center gap-2">
                <span x-text="stickyOn ? 'ON' : 'OFF'" :class="stickyOn ? 'text-blue-600' : 'text-gray-400'" class="text-xs font-bold"></span>
                <button type="button" @click="stickyOn = !stickyOn"
                    :class="stickyOn ? 'bg-blue-600' : 'bg-gray-300 dark:bg-gray-600'"
                    class="relative inline-flex h-7 w-14 flex-shrink-0 items-center rounded-full transition-colors duration-300 focus:outline-none">
                    <span :class="stickyOn ? 'translate-x-7' : 'translate-x-1'" class="inline-block h-5 w-5 transform rounded-full bg-white shadow-md transition-transform duration-300"></span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- =================== السوشيال ميديا =================== --}}
<div x-data="{ open: true }" class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
        <span class="font-semibold text-base">📱 روابط السوشيال ميديا</span>
        <svg :class="open ? 'rotate-180' : ''"
            class="w-5 h-5 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
        <p class="text-xs text-gray-400 mb-3">💡 اترك الحقل فارغاً لإخفاء الأيقونة من الموقع</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach([
                ['key'=>'social_facebook',  'label'=>'Facebook',   'icon'=>'🔵', 'placeholder'=>'https://facebook.com/yourpage'],
                ['key'=>'social_instagram', 'label'=>'Instagram',  'icon'=>'🟣', 'placeholder'=>'https://instagram.com/yourpage'],
                ['key'=>'social_twitter',   'label'=>'X (Twitter)','icon'=>'⬛', 'placeholder'=>'https://x.com/yourpage'],
                ['key'=>'social_whatsapp',  'label'=>'WhatsApp',   'icon'=>'🟢', 'placeholder'=>'https://wa.me/905XXXXXXXXX'],
            ] as $s)
            <div class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                <span class="text-xl">{{ $s['icon'] }}</span>
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-500 mb-1">{{ $s['label'] }}</label>
                    <input type="url" wire:model="data.{{ $s['key'] }}"
                        class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800"
                        placeholder="{{ $s['placeholder'] }}">
                </div>
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
            ['key'=>'color_primary',   'label'=>'اللون الأساسي',  'desc'=>'الأزرار، progress bar'],
            ['key'=>'color_secondary', 'label'=>'اللون الثانوي',  'desc'=>'الغراديانت وبانر الهيرو'],
        ] as $c)
        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <input type="color" wire:model="data.{{ $c['key'] }}" class="w-14 h-10 rounded border cursor-pointer flex-shrink-0">
            <div class="flex-1"><div class="font-medium text-sm">{{ $c['label'] }}</div><div class="text-xs text-gray-400">{{ $c['desc']}}</div></div>
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
            ['key'=>'color_text_dark',   'label'=>'نص غامق','desc'=>'العناوين'],
            ['key'=>'color_text_muted',  'label'=>'نص رمادي','desc'=>'الفقرات'],
            ['key'=>'color_text_label',  'label'=>'نص التسميات','desc'=>'ليبلات'],
            ['key'=>'color_placeholder', 'label'=>'بلسهولدر','desc'=>'حقول الإدخال'],
        ] as $c)
        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <input type="color" wire:model="data.{{ $c['key'] }}" class="w-14 h-10 rounded border cursor-pointer flex-shrink-0">
            <div class="flex-1"><div class="font-medium text-sm">{{ $c['label'] }}</div><div class="text-xs text-gray-400">{{ $c['desc']}}</div></div>
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
            ['key'=>'color_bg_body',  'label'=>'خلفية الصفحة','desc'=>'body'],
            ['key'=>'color_bg_light', 'label'=>'خلفية فاتحة','desc'=>'أقسام'],
            ['key'=>'color_bg_card',  'label'=>'خلفية كروت','desc'=>'كروت'],
        ] as $c)
        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <input type="color" wire:model="data.{{ $c['key'] }}" class="w-14 h-10 rounded border cursor-pointer flex-shrink-0">
            <div class="flex-1"><div class="font-medium text-sm">{{ $c['label'] }}</div><div class="text-xs text-gray-400">{{ $c['desc']}}</div></div>
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
            ['key'=>'color_warning',     'label'=>'لون التحذير','desc'=>'برتقالي'],
            ['key'=>'color_danger',      'label'=>'لون الخطر','desc'=>'أحمر'],
            ['key'=>'color_step_active', 'label'=>'لون الخطوة النشطة','desc'=>'دائرة الخطوة'],
        ] as $c)
        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
            <input type="color" wire:model="data.{{ $c['key'] }}" class="w-14 h-10 rounded border cursor-pointer flex-shrink-0">
            <div class="flex-1"><div class="font-medium text-sm">{{ $c['label'] }}</div><div class="text-xs text-gray-400">{{ $c['desc']}}</div></div>
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
<div x-data="{ open: true }" class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <button type="button" @click="open = !open"
        class="w-full flex items-center justify-between px-5 py-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
        <span class="font-semibold text-base">📞 معلومات التواصل</span>
        <svg :class="open ? 'rotate-180' : ''"
            class="w-5 h-5 text-gray-400 transition-transform duration-200"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" x-transition class="px-5 pb-5 pt-3 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 space-y-5">
        <p class="text-xs text-gray-400">💡 اترك الحقل فارغاً لإخفائه تلقائياً</p>
        <div>
            <p class="text-sm font-semibold mb-2">📞 أرقام الهاتف</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach(['contact_phone'=>'رقم 1','contact_phone_2'=>'رقم 2','contact_phone_3'=>'رقم 3'] as $key=>$label)
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ $label }}</label>
                    <input type="text" wire:model="data.{{ $key }}"
                        class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800" placeholder="+9055XXXXXXXX">
                </div>
                @endforeach
            </div>
        </div>
        <div>
            <p class="text-sm font-semibold mb-2">✉️ البريد الإلكتروني</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach(['contact_email'=>'بريد 1','contact_email_2'=>'بريد 2','contact_email_3'=>'بريد 3'] as $key=>$label)
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ $label }}</label>
                    <input type="email" wire:model="data.{{ $key }}"
                        class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800" placeholder="example@email.com">
                </div>
                @endforeach
            </div>
        </div>
        <div class="space-y-4">
            <p class="text-sm font-semibold">📲 أرقام الواتساب + نص الرسالة</p>
            @foreach([
                ['num'=>'whatsapp_number',   'txt'=>'whatsapp_text_1','label'=>'واتساب 1'],
                ['num'=>'whatsapp_number_2', 'txt'=>'whatsapp_text_2','label'=>'واتساب 2'],
                ['num'=>'whatsapp_number_3', 'txt'=>'whatsapp_text_3','label'=>'واتساب 3'],
            ] as $wa)
            <div class="p-3 rounded-lg border border-gray-200 dark:border-gray-700 space-y-2">
                <p class="text-xs font-semibold text-gray-500">{{ $wa['label'] }}</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">📱 الرقم (بدون +)</label>
                        <input type="text" wire:model="data.{{ $wa['num'] }}"
                            class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800" placeholder="905XXXXXXXXX">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">💬 نص الرسالة</label>
                        <input type="text" wire:model="data.{{ $wa['txt'] }}"
                            class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800" placeholder="مرحباً...">
                    </div>
                </div>
            </div>
            @endforeach
            <p class="text-xs text-gray-400">اترك الرسالة فارغة لفتح المحادثة بدون نص مسبق</p>
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
                <label class="block text-sm font-medium mb-1">كلمة المرور الجديدة</label>
                <input type="password" wire:model="data.admin_password" placeholder="••••••••"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
        </div>
    </div>
</div>

</div>
<div class="mt-6 flex justify-end">
    <x-filament::button type="submit" size="lg" color="success">
        💾 حفظ كل الإعدادات
    </x-filament::button>
</div>
</form>
</x-filament-panels::page>
