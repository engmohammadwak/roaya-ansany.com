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
            <div
                x-data="{ on: @js(($this->data['maintenance_mode'] ?? '0') === '1') }"
                x-init="$watch('on', v => @this.set('data.maintenance_mode', v ? '1' : '0'))"
                class="rounded-lg border border-amber-200 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/20 p-4 flex items-center justify-between">
                <div>
                    <label class="block text-sm font-medium mb-1">وضع الصيانة</label>
                    <p class="text-xs text-gray-500">عند التفعيل سيظهر للزوار صفحة تحت الصيانة، بينما تبقى لوحة الإدارة متاحة.</p>
                </div>
                <div class="flex items-center gap-3">
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

{{-- بقية الملف كما هو --}}
@include('filament.pages.partials.site-settings-body')

</div>
<div class="mt-6 flex justify-end">
    <x-filament::button type="submit" size="lg" color="success">
        💾 حفظ كل الإعدادات
    </x-filament::button>
</div>
</form>
</x-filament-panels::page>
