<x-filament-panels::page>
    <form wire:submit="save">
        <div class="space-y-6">

            {{-- الهوية --}}
            <x-filament::section heading="🌐 هوية الموقع">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">اسم الموقع</label>
                        <input type="text" wire:model="data.site_name"
                            class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">رابط الفافيكون (favicon)</label>
                        <input type="text" wire:model="data.site_favicon"
                            placeholder="/favicon.ico"
                            class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">رابط الشعار (Logo URL)</label>
                        <input type="text" wire:model="data.site_logo"
                            placeholder="/storage/logo.png"
                            class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                    </div>
                </div>
            </x-filament::section>

            {{-- الألوان --}}
            <x-filament::section heading="🎨 ألوان الموقع الرئيسية">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">اللون الأساسي (Primary)</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model="data.primary_color"
                                class="w-12 h-10 rounded border cursor-pointer">
                            <input type="text" wire:model="data.primary_color"
                                placeholder="#5a9e2f"
                                class="fi-input flex-1 rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">اللون الثانوي (Secondary)</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model="data.secondary_color"
                                class="w-12 h-10 rounded border cursor-pointer">
                            <input type="text" wire:model="data.secondary_color"
                                placeholder="#8bc34a"
                                class="fi-input flex-1 rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                        </div>
                    </div>
                </div>
            </x-filament::section>

            {{-- الفوتر --}}
            <x-filament::section heading="📌 الفوتر">
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
                            placeholder="جميع الحقوق محفوظة © مؤسسة رؤيا الإنسانية 2026"
                            class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">نص الحقوق (إنجليزي)</label>
                        <input type="text" wire:model="data.footer_copyright_en"
                            placeholder="All rights reserved © Roaya Insanya 2026"
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
                            placeholder="+905398863777"
                            class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">البريد الإلكتروني</label>
                        <input type="email" wire:model="data.contact_email"
                            placeholder="roaya.ansany@gmail.com"
                            class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">رقم واتساب</label>
                        <input type="text" wire:model="data.whatsapp_number"
                            placeholder="+905398863777"
                            class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
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
                        <label class="block text-sm font-medium mb-1">كلمة المرور الجديدة (اتركها فارغة إذا لا تريد تغييرها)</label>
                        <input type="password" wire:model="data.admin_password"
                            placeholder="••••••••"
                            class="fi-input w-full rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm bg-white dark:bg-gray-800">
                    </div>
                </div>
            </x-filament::section>

        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="fi-btn fi-btn-size-md fi-color-primary fi-btn-color-primary px-6 py-2 rounded-lg bg-primary-600 text-white font-semibold hover:bg-primary-700 transition">
                💾 حفظ الإعدادات
            </button>
        </div>
    </form>
</x-filament-panels::page>
