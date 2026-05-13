<x-filament-panels::page>

    {{-- ===== SECTION TABS ===== --}}
    <div class="flex gap-2 mb-6 border-b border-gray-200 dark:border-gray-700">
        @foreach([
            'campaigns' => ['📣', 'الحملات'],
            'projects'  => ['🌱', 'المشاريع'],
            'programs'  => ['📌', 'البرامج'],
        ] as $key => [$icon, $label])
        <button
            wire:click="switchSection('{{ $key }}')"
            class="px-5 py-2.5 text-sm font-medium border-b-2 transition-all
                {{ $this->activeSection === $key
                    ? 'border-primary-500 text-primary-600 dark:text-primary-400'
                    : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' }}"
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
    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-xl shadow">
        <table class="w-full text-sm text-right">
            <thead class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3">الصورة</th>
                    <th class="px-4 py-3">المشروع</th>
                    <th class="px-4 py-3">الدولة</th>
                    <th class="px-4 py-3">الهدف</th>
                    <th class="px-4 py-3">المجمّع</th>
                    <th class="px-4 py-3">نشط</th>
                    <th class="px-4 py-3">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Project::orderBy('sort_order')->get() as $row)
                <tr class="border-t border-gray-100 dark:border-gray-700">
                    <td class="px-4 py-3">
                        @if($row->image)
                        <img src="{{ Storage::url($row->image) }}" class="h-12 w-16 object-cover rounded">
                        @endif
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $row->title_ar }}</td>
                    <td class="px-4 py-3">{{ $row->country_ar }}</td>
                    <td class="px-4 py-3">{{ number_format($row->goal_amount) }}</td>
                    <td class="px-4 py-3">{{ number_format($row->raised_amount) }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block w-3 h-3 rounded-full {{ $row->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        <button wire:click="editProject({{ $row->id }})" class="text-primary-600 hover:underline text-xs">تعديل</button>
                        <button wire:click="deleteProject({{ $row->id }})" wire:confirm="هل أنت متأكد؟" class="text-danger-600 hover:underline text-xs">حذف</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-8 text-gray-400">لا توجد مشاريع</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    {{-- ===== PROGRAMS TAB ===== --}}
    @if($this->activeSection === 'programs')
    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded-xl shadow">
        <table class="w-full text-sm text-right">
            <thead class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3">الصورة</th>
                    <th class="px-4 py-3">البرنامج</th>
                    <th class="px-4 py-3">التصنيف</th>
                    <th class="px-4 py-3">الأيقونة</th>
                    <th class="px-4 py-3">نشط</th>
                    <th class="px-4 py-3">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Program::orderBy('sort_order')->get() as $row)
                <tr class="border-t border-gray-100 dark:border-gray-700">
                    <td class="px-4 py-3">
                        @if($row->image)
                        <img src="{{ Storage::url($row->image) }}" class="h-12 w-16 object-cover rounded">
                        @endif
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $row->title_ar }}</td>
                    <td class="px-4 py-3">{{ $row->category_ar }}</td>
                    <td class="px-4 py-3">{{ $row->icon }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block w-3 h-3 rounded-full {{ $row->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        <button wire:click="editProgram({{ $row->id }})" class="text-primary-600 hover:underline text-xs">تعديل</button>
                        <button wire:click="deleteProgram({{ $row->id }})" wire:confirm="هل أنت متأكد؟" class="text-danger-600 hover:underline text-xs">حذف</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-8 text-gray-400">لا توجد برامج</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    {{-- ===== PROJECT MODAL ===== --}}
    @if($this->showProjectModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
            <h2 class="text-lg font-bold mb-4">{{ $this->editingProjectId ? 'تعديل مشروع' : 'مشروع جديد' }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="text-xs text-gray-500">الاسم (عربي) *</label><input wire:model="projectData.title_ar" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">الاسم (إنجليزي)</label><input wire:model="projectData.title_en" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">الدولة (عربي)</label><input wire:model="projectData.country_ar" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">الدولة (إنجليزي)</label><input wire:model="projectData.country_en" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">مبلغ الهدف</label><input wire:model="projectData.goal_amount" type="number" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">المبلغ المجمّع</label><input wire:model="projectData.raised_amount" type="number" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">الوصف (عربي)</label><textarea wire:model="projectData.description_ar" rows="2" class="w-full border rounded px-3 py-2 mt-1 text-sm"></textarea></div>
                <div><label class="text-xs text-gray-500">الوصف (إنجليزي)</label><textarea wire:model="projectData.description_en" rows="2" class="w-full border rounded px-3 py-2 mt-1 text-sm"></textarea></div>
                <div class="col-span-2 flex items-center gap-2">
                    <input type="checkbox" wire:model="projectData.is_active" id="proj_active">
                    <label for="proj_active" class="text-sm">نشط</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button wire:click="$set('showProjectModal', false)" class="px-4 py-2 rounded bg-gray-100 text-gray-700 text-sm">إلغاء</button>
                <button wire:click="saveProject" class="px-4 py-2 rounded bg-primary-600 text-white text-sm font-medium">حفظ</button>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== PROGRAM MODAL ===== --}}
    @if($this->showProgramModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
            <h2 class="text-lg font-bold mb-4">{{ $this->editingProgramId ? 'تعديل برنامج' : 'برنامج جديد' }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="text-xs text-gray-500">الاسم (عربي) *</label><input wire:model="programData.title_ar" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">الاسم (إنجليزي)</label><input wire:model="programData.title_en" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">التصنيف (عربي)</label><input wire:model="programData.category_ar" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">التصنيف (إنجليزي)</label><input wire:model="programData.category_en" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">الأيقونة (Emoji)</label><input wire:model="programData.icon" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">الترتيب</label><input wire:model="programData.sort_order" type="number" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">الوصف (عربي)</label><textarea wire:model="programData.description_ar" rows="2" class="w-full border rounded px-3 py-2 mt-1 text-sm"></textarea></div>
                <div><label class="text-xs text-gray-500">الوصف (إنجليزي)</label><textarea wire:model="programData.description_en" rows="2" class="w-full border rounded px-3 py-2 mt-1 text-sm"></textarea></div>
                <div class="col-span-2 flex items-center gap-2">
                    <input type="checkbox" wire:model="programData.is_active" id="prog_active">
                    <label for="prog_active" class="text-sm">نشط</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button wire:click="$set('showProgramModal', false)" class="px-4 py-2 rounded bg-gray-100 text-gray-700 text-sm">إلغاء</button>
                <button wire:click="saveProgram" class="px-4 py-2 rounded bg-primary-600 text-white text-sm font-medium">حفظ</button>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== SETTINGS MODAL ===== --}}
    @if($this->showSettingsModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl p-6">
            <h2 class="text-lg font-bold mb-4">إعدادات صفحة
                @if($this->activeSection === 'campaigns') الحملات
                @elseif($this->activeSection === 'projects') المشاريع
                @else البرامج
                @endif
            </h2>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="text-xs text-gray-500">العنوان (عربي)</label><input wire:model="settingsData.hero_title_ar" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">العنوان (إنجليزي)</label><input wire:model="settingsData.hero_title_en" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">الوصف (عربي)</label><textarea wire:model="settingsData.hero_desc_ar" rows="3" class="w-full border rounded px-3 py-2 mt-1 text-sm"></textarea></div>
                <div><label class="text-xs text-gray-500">الوصف (إنجليزي)</label><textarea wire:model="settingsData.hero_desc_en" rows="3" class="w-full border rounded px-3 py-2 mt-1 text-sm"></textarea></div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button wire:click="$set('showSettingsModal', false)" class="px-4 py-2 rounded bg-gray-100 text-gray-700 text-sm">إلغاء</button>
                <button wire:click="saveSettings" class="px-4 py-2 rounded bg-primary-600 text-white text-sm font-medium">حفظ</button>
            </div>
        </div>
    </div>
    @endif

</x-filament-panels::page>
