<x-filament-panels::page>

    <div class="space-y-6">

        {{-- ======================================================
             CARD 1 — Create new backup
        ====================================================== --}}
        <x-filament::section>
            <x-slot name="heading">► إنشاء نسخة احتياطية جديدة</x-slot>
            <x-slot name="description">تشمل قاعدة البيانات كاملة + جميع الصور والملفات المرفوعة — يحفظ كملف <code>.zip</code> واحد</x-slot>

            <div class="flex items-center gap-4 flex-wrap">
                <x-filament::button
                    wire:click="createBackup"
                    wire:loading.attr="disabled"
                    color="primary"
                    icon="heroicon-o-archive-box-arrow-down"
                    size="lg"
                >
                    <span wire:loading.remove wire:target="createBackup">► إنشاء نسخة احتياطية الآن</span>
                    <span wire:loading wire:target="createBackup">جاري الإنشاء… قد يستغرق دقيقة</span>
                </x-filament::button>

                <div class="text-sm text-gray-500 space-y-0.5">
                    <p>🗄️ تشمل النسخة: <strong>قاعدة البيانات</strong> + <strong>مجلد storage/app/public</strong> (الصور، الشعارات، الملفات)</p>
                    <p>💾 يتم الحفظ في: <code>storage/app/backups/</code></p>
                </div>
            </div>
        </x-filament::section>

        {{-- ======================================================
             CARD 2 — Existing backups list
        ====================================================== --}}
        <x-filament::section>
            <x-slot name="heading">🗂️ النسخ الاحتياطية المحفوظة</x-slot>
            <x-slot name="description">يمكنك تحميل أي نسخة إلى جهازك أو حذفها</x-slot>

            @if(count($backups) === 0)
                <p class="text-sm text-gray-400 py-6 text-center">لا توجد نسخ احتياطية حتى الآن. أنشئ أولى نسخة من البطاقة أعلاه ↑</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right">
                        <thead class="text-xs text-gray-500 border-b">
                            <tr>
                                <th class="py-2 px-3">اسم الملف</th>
                                <th class="py-2 px-3">الحجم</th>
                                <th class="py-2 px-3">التاريخ</th>
                                <th class="py-2 px-3">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($backups as $backup)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="py-2 px-3 font-mono text-xs">
                                    🗄️ {{ $backup['name'] }}
                                </td>
                                <td class="py-2 px-3">{{ $backup['size'] }}</td>
                                <td class="py-2 px-3">{{ $backup['date'] }}</td>
                                <td class="py-2 px-3">
                                    <div class="flex gap-2">
                                        <x-filament::button
                                            wire:click="downloadBackup('{{ $backup['path'] }}')"
                                            size="xs"
                                            color="gray"
                                            icon="heroicon-o-arrow-down-tray"
                                        >تحميل</x-filament::button>

                                        <x-filament::button
                                            wire:click="deleteBackup('{{ $backup['path'] }}')"
                                            wire:confirm="هل أنت متأكد من حذف هذه النسخة؟"
                                            size="xs"
                                            color="danger"
                                            icon="heroicon-o-trash"
                                        >حذف</x-filament::button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-filament::section>

        {{-- ======================================================
             CARD 3 — Upload & Restore
        ====================================================== --}}
        <x-filament::section>
            <x-slot name="heading">↩ رفع واستعادة نسخة احتياطية</x-slot>
            <x-slot name="description">
                <span class="text-yellow-600 font-semibold">⚠️ تحذير:</span>
                سيتم حذف وإعادة كتابة <strong>قاعدة البيانات كاملة</strong> + استبدال <strong>الصور والملفات</strong>. لا تكمل إلا إذا كنت متأكدًا.
            </x-slot>

            <div class="space-y-4 max-w-lg">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        اختر ملف النسخة (.zip)
                    </label>
                    <input
                        type="file"
                        wire:model="backup_file"
                        accept=".zip"
                        class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2"
                    />
                    @error('backup_file')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-400 mt-1">الحجم الأقصى: 500 MB</p>
                </div>

                <x-filament::button
                    wire:click="restoreBackup"
                    wire:loading.attr="disabled"
                    wire:confirm="تأكيد استعادة النسخة؟ سيتم الكتابة فوق جميع البيانات والصور الحالية!"
                    color="warning"
                    icon="heroicon-o-arrow-up-tray"
                    size="lg"
                >
                    <span wire:loading.remove wire:target="restoreBackup">↩ استعادة كاملة (DB + صور)</span>
                    <span wire:loading wire:target="restoreBackup">جاري الاستعادة…</span>
                </x-filament::button>
            </div>
        </x-filament::section>

    </div>

</x-filament-panels::page>
