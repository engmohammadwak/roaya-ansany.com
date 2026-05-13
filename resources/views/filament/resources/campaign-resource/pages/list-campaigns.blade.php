<x-filament-panels::page>

    {{-- ===== SECTION TABS ===== --}}
    <div class="fi-tabs flex gap-2 mb-6 border-b border-gray-200 dark:border-gray-700">
        @foreach([
            'campaigns' => ['📣', 'الحملات'],
            'projects'  => ['🌱', 'المشاريع'],
            'programs'  => ['📌', 'البرامج'],
        ] as $key => [$icon, $label])
        <button
            wire:click="switchSection('{{ $key }}')"
            @class([
                'px-5 py-2.5 text-sm font-medium border-b-2 transition-all',
                'border-primary-500 text-primary-600 dark:text-primary-400' => $this->activeSection === $key,
                'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' => $this->activeSection !== $key,
            ])
        >
            {{ $icon }} {{ $label }}
        </button>
        @endforeach
    </div>

    {{-- ===== CAMPAIGNS TAB ===== --}}
    @if($this->activeSection === 'campaigns')
        {{ $this->table }}
    @endif

    {{-- ===== PROJECTS TAB ===== --}}
    @if($this->activeSection === 'projects')
    <div class="overflow-x-auto fi-ta-ctn rounded-xl shadow">
        <table class="fi-ta-table w-full text-sm text-right divide-y divide-gray-200 dark:divide-white/5">
            <thead class="bg-gray-50 dark:bg-white/5">
                <tr>
                    @foreach(['الصورة','المشروع','الدولة','الهدف','المجمّع','نشط','إجراءات'] as $h)
                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-white/5">
                @forelse(\App\Models\Project::orderBy('sort_order')->get() as $row)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                    <td class="px-4 py-3">
                        @if($row->image)<img src="{{ Storage::url($row->image) }}" class="h-12 w-16 object-cover rounded">@endif
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $row->title_ar }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $row->country_ar }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ number_format($row->goal_amount) }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ number_format($row->raised_amount) }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block w-2.5 h-2.5 rounded-full {{ $row->is_active ? 'bg-success-500' : 'bg-gray-300' }}"></span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-3">
                            <button wire:click="editProject({{ $row->id }})" class="text-primary-600 hover:text-primary-500 text-xs font-medium">تعديل</button>
                            <button wire:click="deleteProject({{ $row->id }})" wire:confirm="هل أنت متأكد؟" class="text-danger-600 hover:text-danger-500 text-xs font-medium">حذف</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-10 text-gray-400 dark:text-gray-500">لا توجد مشاريع</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    {{-- ===== PROGRAMS TAB ===== --}}
    @if($this->activeSection === 'programs')
    <div class="overflow-x-auto fi-ta-ctn rounded-xl shadow">
        <table class="fi-ta-table w-full text-sm text-right divide-y divide-gray-200 dark:divide-white/5">
            <thead class="bg-gray-50 dark:bg-white/5">
                <tr>
                    @foreach(['الصورة','البرنامج','التصنيف','الأيقونة','نشط','إجراءات'] as $h)
                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-white/5">
                @forelse(\App\Models\Program::orderBy('sort_order')->get() as $row)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                    <td class="px-4 py-3">
                        @if($row->image)<img src="{{ Storage::url($row->image) }}" class="h-12 w-16 object-cover rounded">@endif
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $row->title_ar }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $row->category_ar }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $row->icon }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block w-2.5 h-2.5 rounded-full {{ $row->is_active ? 'bg-success-500' : 'bg-gray-300' }}"></span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-3">
                            <button wire:click="editProgram({{ $row->id }})" class="text-primary-600 hover:text-primary-500 text-xs font-medium">تعديل</button>
                            <button wire:click="deleteProgram({{ $row->id }})" wire:confirm="هل أنت متأكد؟" class="text-danger-600 hover:text-danger-500 text-xs font-medium">حذف</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-10 text-gray-400 dark:text-gray-500">لا توجد برامج</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    {{-- INPUT STYLE reused via php var --}}
    @php
    $inp = 'block w-full rounded-lg border border-gray-300 dark:border-white/20'
         . ' bg-white dark:bg-gray-800'
         . ' text-gray-900 dark:text-white'
         . ' placeholder-gray-400 dark:placeholder-gray-500'
         . ' shadow-sm px-3 py-2 text-sm'
         . ' focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500'
         . ' transition';
    @endphp

    {{-- ===== PROJECT MODAL ===== --}}
    @if($this->showProjectModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-white/10">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ $this->editingProjectId ? 'تعديل مشروع' : 'مشروع جديد' }}</h2>
                <button wire:click="$set('showProjectModal',false)" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">✕</button>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الاسم (عربي) *</label><input wire:model="projectData.title_ar" type="text" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الاسم (إنجليزي)</label><input wire:model="projectData.title_en" type="text" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الدولة (عربي)</label><input wire:model="projectData.country_ar" type="text" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الدولة (إنجليزي)</label><input wire:model="projectData.country_en" type="text" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">مبلغ الهدف</label><input wire:model="projectData.goal_amount" type="number" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">المبلغ المجمّع</label><input wire:model="projectData.raised_amount" type="number" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1 sm:col-span-2"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الوصف (عربي)</label><textarea wire:model="projectData.description_ar" rows="3" class="{{ $inp }}"></textarea></div>
                <div class="flex flex-col gap-1 sm:col-span-2"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الوصف (إنجليزي)</label><textarea wire:model="projectData.description_en" rows="3" class="{{ $inp }}"></textarea></div>
                <div class="sm:col-span-2 flex items-center gap-2">
                    <input type="checkbox" wire:model="projectData.is_active" id="proj_active" class="rounded border-gray-300">
                    <label for="proj_active" class="text-sm text-gray-700 dark:text-gray-300">نشط</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-white/10">
                <x-filament::button color="gray" wire:click="$set('showProjectModal',false)">إلغاء</x-filament::button>
                <x-filament::button wire:click="saveProject">حفظ</x-filament::button>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== PROGRAM MODAL ===== --}}
    @if($this->showProgramModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-white/10">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ $this->editingProgramId ? 'تعديل برنامج' : 'برنامج جديد' }}</h2>
                <button wire:click="$set('showProgramModal',false)" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">✕</button>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الاسم (عربي) *</label><input wire:model="programData.title_ar" type="text" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الاسم (إنجليزي)</label><input wire:model="programData.title_en" type="text" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">التصنيف (عربي)</label><input wire:model="programData.category_ar" type="text" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">التصنيف (إنجليزي)</label><input wire:model="programData.category_en" type="text" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الأيقونة (Emoji)</label><input wire:model="programData.icon" type="text" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الترتيب</label><input wire:model="programData.sort_order" type="number" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1 sm:col-span-2"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الوصف (عربي)</label><textarea wire:model="programData.description_ar" rows="3" class="{{ $inp }}"></textarea></div>
                <div class="flex flex-col gap-1 sm:col-span-2"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الوصف (إنجليزي)</label><textarea wire:model="programData.description_en" rows="3" class="{{ $inp }}"></textarea></div>
                <div class="sm:col-span-2 flex items-center gap-2">
                    <input type="checkbox" wire:model="programData.is_active" id="prog_active" class="rounded border-gray-300">
                    <label for="prog_active" class="text-sm text-gray-700 dark:text-gray-300">نشط</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-white/10">
                <x-filament::button color="gray" wire:click="$set('showProgramModal',false)">إلغاء</x-filament::button>
                <x-filament::button wire:click="saveProgram">حفظ</x-filament::button>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== SETTINGS MODAL ===== --}}
    @if($this->showSettingsModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-white/10">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">
                    إعدادات صفحة
                    @if($this->activeSection==='campaigns') الحملات
                    @elseif($this->activeSection==='projects') المشاريع
                    @else البرامج @endif
                </h2>
                <button wire:click="$set('showSettingsModal',false)" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">✕</button>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">العنوان (عربي)</label><input wire:model="s_hero_title_ar" type="text" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">العنوان (إنجليزي)</label><input wire:model="s_hero_title_en" type="text" class="{{ $inp }}"></div>
                <div class="flex flex-col gap-1 sm:col-span-2"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الوصف (عربي)</label><textarea wire:model="s_hero_desc_ar" rows="3" class="{{ $inp }}"></textarea></div>
                <div class="flex flex-col gap-1 sm:col-span-2"><label class="text-xs font-medium text-gray-600 dark:text-gray-400">الوصف (إنجليزي)</label><textarea wire:model="s_hero_desc_en" rows="3" class="{{ $inp }}"></textarea></div>
            </div>
            <div class="flex justify-end gap-3 px-6 py-4 border-t border-gray-200 dark:border-white/10">
                <x-filament::button color="gray" wire:click="$set('showSettingsModal',false)">إلغاء</x-filament::button>
                <x-filament::button wire:click="saveSettings">حفظ</x-filament::button>
            </div>
        </div>
    </div>
    @endif

</x-filament-panels::page>
