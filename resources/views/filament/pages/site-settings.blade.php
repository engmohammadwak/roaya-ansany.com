<x-filament-panels::page>
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

            {{-- شعار الموقع --}}
            <div>
                <label class="block text-sm font-medium mb-2">🎨 شعار الموقع (Logo) — يظهر في النافبار و الفوتر</label>
                @if(Setting::get('site_logo'))
                    <img src="{{ Setting::get('site_logo') }}" alt="Logo" class="h-16 mb-2 rounded">
                @endif
                <input type="file" wire:model="logo_upload" accept="image/*"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                <p class="text-xs text-gray-400 mt-1">ينصح باستخدام PNG بخلفية شفافة أو SVG</p>
            </div>

            {{-- فافيكون --}}
            <div>
                <label class="block text-sm font-medium mb-2">🔖 الفافيكون (Favicon) — الأيقونة في عنوان التاب</label>
                @if(Setting::get('site_favicon'))
                    <img src="{{ Setting::get('site_favicon') }}" alt="Favicon" class="h-10 mb-2">
                @endif
                <input type="file" wire:model="favicon_upload" accept="image/*,.ico"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
        </div>
    </x-filament::section>

    {{-- الألوان --}}
    <x-filament::section heading="🎨 ألوان الموقع">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">اللون الأساسي (Primary Color)</label>
                <div class="flex items-center gap-3">
                    <input type="color" wire:model="data.primary_color" class="w-12 h-10 rounded border cursor-pointer">
                    <input type="text" wire:model="data.primary_color" placeholder="#5a9e2f"
                        class="fi-input flex-1 rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">اللون الثانوي (Secondary Color)</label>
                <div class="flex items-center gap-3">
                    <input type="color" wire:model="data.secondary_color" class="w-12 h-10 rounded border cursor-pointer">
                    <input type="text" wire:model="data.secondary_color" placeholder="#8bc34a"
                        class="fi-input flex-1 rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                </div>
            </div>
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
                <input type="text" wire:model="data.contact_phone" placeholder="+905398863777"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">البريد الإلكتروني</label>
                <input type="email" wire:model="data.contact_email" placeholder="roaya.ansany@gmail.com"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">📲 رقم الواتساب (بدون +)</label>
                <input type="text" wire:model="data.whatsapp_number" placeholder="905398863777"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                <p class="text-xs text-gray-400 mt-1">مثال: 905398863777</p>
            </div>
        </div>
    </x-filament::section>

    {{-- حساب الأدمن --}}
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
                <label class="block text-sm font-medium mb-1">كلمة المرور الجديدة (اتركها فارغة إذا لا تريد تغيير)</label>
                <input type="password" wire:model="data.admin_password" placeholder="••••••••"
                    class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
            </div>
        </div>
    </x-filament::section>

</div>

<div class="mt-6 flex justify-end">
    <x-filament::button type="submit" size="lg" color="success">
        💾 حفظ الإعدادات
    </x-filament::button>
</div>
</form>
</x-filament-panels::page>
