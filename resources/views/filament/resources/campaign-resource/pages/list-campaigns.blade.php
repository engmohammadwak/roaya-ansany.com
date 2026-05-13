<x-filament-panels::page>

    {{-- ===== SECTION TABS ===== --}}
    <div class="flex gap-2 mb-6 border-b border-gray-200 dark:border-gray-700">
        @foreach([
            'campaigns' => ['📣', '\u0627\u0644\u062d\u0645\u0644\u0627\u062a'],
            'projects'  => ['\ud83c\udf31', '\u0627\u0644\u0645\u0634\u0627\u0631\u064a\u0639'],
            'programs'  => ['\ud83d\udccc', '\u0627\u0644\u0628\u0631\u0627\u0645\u062c'],
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
                    <th class="px-4 py-3">\u0627\u0644\u0635\u0648\u0631\u0629</th>
                    <th class="px-4 py-3">\u0627\u0644\u0645\u0634\u0631\u0648\u0639</th>
                    <th class="px-4 py-3">\u0627\u0644\u062f\u0648\u0644\u0629</th>
                    <th class="px-4 py-3">\u0627\u0644\u0647\u062f\u0641</th>
                    <th class="px-4 py-3">\u0627\u0644\u0645\u062c\u0645\u0651\u0639</th>
                    <th class="px-4 py-3">\u0646\u0634\u0637</th>
                    <th class="px-4 py-3">\u0625\u062c\u0631\u0627\u0621\u0627\u062a</th>
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
                        <button wire:click="editProject({{ $row->id }})" class="text-primary-600 hover:underline text-xs">\u062a\u0639\u062f\u064a\u0644</button>
                        <button wire:click="deleteProject({{ $row->id }})" wire:confirm="\u0647\u0644 \u0623\u0646\u062a \u0645\u062a\u0623\u0643\u062f\u061f" class="text-danger-600 hover:underline text-xs">\u062d\u0630\u0641</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-8 text-gray-400">\u0644\u0627 \u062a\u0648\u062c\u062f \u0645\u0634\u0627\u0631\u064a\u0639</td></tr>
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
                    <th class="px-4 py-3">\u0627\u0644\u0635\u0648\u0631\u0629</th>
                    <th class="px-4 py-3">\u0627\u0644\u0628\u0631\u0646\u0627\u0645\u062c</th>
                    <th class="px-4 py-3">\u0627\u0644\u062a\u0635\u0646\u064a\u0641</th>
                    <th class="px-4 py-3">\u0627\u0644\u0623\u064a\u0642\u0648\u0646\u0629</th>
                    <th class="px-4 py-3">\u0646\u0634\u0637</th>
                    <th class="px-4 py-3">\u0625\u062c\u0631\u0627\u0621\u0627\u062a</th>
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
                        <button wire:click="editProgram({{ $row->id }})" class="text-primary-600 hover:underline text-xs">\u062a\u0639\u062f\u064a\u0644</button>
                        <button wire:click="deleteProgram({{ $row->id }})" wire:confirm="\u0647\u0644 \u0623\u0646\u062a \u0645\u062a\u0623\u0643\u062f\u061f" class="text-danger-600 hover:underline text-xs">\u062d\u0630\u0641</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-8 text-gray-400">\u0644\u0627 \u062a\u0648\u062c\u062f \u0628\u0631\u0627\u0645\u062c</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    {{-- ===== PROJECT MODAL ===== --}}
    @if($this->showProjectModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
            <h2 class="text-lg font-bold mb-4">{{ $this->editingProjectId ? '\u062a\u0639\u062f\u064a\u0644 \u0645\u0634\u0631\u0648\u0639' : '\u0645\u0634\u0631\u0648\u0639 \u062c\u062f\u064a\u062f' }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0627\u0633\u0645 (\u0639\u0631\u0628\u064a) *</label><input wire:model="projectData.title_ar" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0627\u0633\u0645 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)</label><input wire:model="projectData.title_en" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u062f\u0648\u0644\u0629 (\u0639\u0631\u0628\u064a)</label><input wire:model="projectData.country_ar" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u062f\u0648\u0644\u0629 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)</label><input wire:model="projectData.country_en" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0645\u0628\u0644\u063a \u0627\u0644\u0647\u062f\u0641</label><input wire:model="projectData.goal_amount" type="number" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0645\u0628\u0644\u063a \u0627\u0644\u0645\u062c\u0645\u0651\u0639</label><input wire:model="projectData.raised_amount" type="number" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0648\u0635\u0641 (\u0639\u0631\u0628\u064a)</label><textarea wire:model="projectData.description_ar" rows="2" class="w-full border rounded px-3 py-2 mt-1 text-sm"></textarea></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0648\u0635\u0641 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)</label><textarea wire:model="projectData.description_en" rows="2" class="w-full border rounded px-3 py-2 mt-1 text-sm"></textarea></div>
                <div class="col-span-2 flex items-center gap-2">
                    <input type="checkbox" wire:model="projectData.is_active" id="proj_active">
                    <label for="proj_active" class="text-sm">\u0646\u0634\u0637</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button wire:click="$set('showProjectModal', false)" class="px-4 py-2 rounded bg-gray-100 text-gray-700 text-sm">\u0625\u0644\u063a\u0627\u0621</button>
                <button wire:click="saveProject" class="px-4 py-2 rounded bg-primary-600 text-white text-sm font-medium">\u062d\u0641\u0638</button>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== PROGRAM MODAL ===== --}}
    @if($this->showProgramModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
            <h2 class="text-lg font-bold mb-4">{{ $this->editingProgramId ? '\u062a\u0639\u062f\u064a\u0644 \u0628\u0631\u0646\u0627\u0645\u062c' : '\u0628\u0631\u0646\u0627\u0645\u062c \u062c\u062f\u064a\u062f' }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0627\u0633\u0645 (\u0639\u0631\u0628\u064a) *</label><input wire:model="programData.title_ar" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0627\u0633\u0645 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)</label><input wire:model="programData.title_en" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u062a\u0635\u0646\u064a\u0641 (\u0639\u0631\u0628\u064a)</label><input wire:model="programData.category_ar" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u062a\u0635\u0646\u064a\u0641 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)</label><input wire:model="programData.category_en" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0623\u064a\u0642\u0648\u0646\u0629 (Emoji)</label><input wire:model="programData.icon" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u062a\u0631\u062a\u064a\u0628</label><input wire:model="programData.sort_order" type="number" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0648\u0635\u0641 (\u0639\u0631\u0628\u064a)</label><textarea wire:model="programData.description_ar" rows="2" class="w-full border rounded px-3 py-2 mt-1 text-sm"></textarea></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0648\u0635\u0641 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)</label><textarea wire:model="programData.description_en" rows="2" class="w-full border rounded px-3 py-2 mt-1 text-sm"></textarea></div>
                <div class="col-span-2 flex items-center gap-2">
                    <input type="checkbox" wire:model="programData.is_active" id="prog_active">
                    <label for="prog_active" class="text-sm">\u0646\u0634\u0637</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button wire:click="$set('showProgramModal', false)" class="px-4 py-2 rounded bg-gray-100 text-gray-700 text-sm">\u0625\u0644\u063a\u0627\u0621</button>
                <button wire:click="saveProgram" class="px-4 py-2 rounded bg-primary-600 text-white text-sm font-medium">\u062d\u0641\u0638</button>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== SETTINGS MODAL ===== --}}
    @if($this->showSettingsModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-2xl p-6">
            <h2 class="text-lg font-bold mb-4">\u0625\u0639\u062f\u0627\u062f\u0627\u062a \u0635\u0641\u062d\u0629 {{ ['campaigns'=>'\u0627\u0644\u062d\u0645\u0644\u0627\u062a','projects'=>'\u0627\u0644\u0645\u0634\u0627\u0631\u064a\u0639','programs'=>'\u0627\u0644\u0628\u0631\u0627\u0645\u062c'][$this->activeSection] }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0639\u0646\u0648\u0627\u0646 (\u0639\u0631\u0628\u064a)</label><input wire:model="settingsData.hero_title_ar" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0639\u0646\u0648\u0627\u0646 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)</label><input wire:model="settingsData.hero_title_en" type="text" class="w-full border rounded px-3 py-2 mt-1 text-sm"></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0648\u0635\u0641 (\u0639\u0631\u0628\u064a)</label><textarea wire:model="settingsData.hero_desc_ar" rows="3" class="w-full border rounded px-3 py-2 mt-1 text-sm"></textarea></div>
                <div><label class="text-xs text-gray-500">\u0627\u0644\u0648\u0635\u0641 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)</label><textarea wire:model="settingsData.hero_desc_en" rows="3" class="w-full border rounded px-3 py-2 mt-1 text-sm"></textarea></div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button wire:click="$set('showSettingsModal', false)" class="px-4 py-2 rounded bg-gray-100 text-gray-700 text-sm">\u0625\u0644\u063a\u0627\u0621</button>
                <button wire:click="saveSettings" class="px-4 py-2 rounded bg-primary-600 text-white text-sm font-medium">\u062d\u0641\u0638</button>
            </div>
        </div>
    </div>
    @endif

</x-filament-panels::page>
