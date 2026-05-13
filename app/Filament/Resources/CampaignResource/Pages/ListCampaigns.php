<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use App\Filament\Resources\CampaignResource;
use App\Models\Program;
use App\Models\Project;
use App\Models\Setting;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListCampaigns extends ListRecords
{
    protected static string $resource = CampaignResource::class;

    public string $activeSection = 'campaigns';

    // Modals
    public bool  $showProjectModal  = false;
    public bool  $showProgramModal  = false;
    public bool  $showSettingsModal = false;
    public ?int  $editingProjectId  = null;
    public ?int  $editingProgramId  = null;
    public array $projectData       = [];
    public array $programData       = [];

    // Settings — individual properties (wire:model doesn't work with nested arrays)
    public string $s_hero_title_ar = '';
    public string $s_hero_title_en = '';
    public string $s_hero_desc_ar  = '';
    public string $s_hero_desc_en  = '';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('إضافة حملة')
                ->visible(fn () => $this->activeSection === 'campaigns'),

            Actions\Action::make('new_project')
                ->label('إضافة مشروع')
                ->icon('heroicon-o-plus')
                ->visible(fn () => $this->activeSection === 'projects')
                ->action(function () {
                    $this->editingProjectId = null;
                    $this->projectData = [];
                    $this->showProjectModal = true;
                }),

            Actions\Action::make('new_program')
                ->label('إضافة برنامج')
                ->icon('heroicon-o-plus')
                ->visible(fn () => $this->activeSection === 'programs')
                ->action(function () {
                    $this->editingProgramId = null;
                    $this->programData = [];
                    $this->showProgramModal = true;
                }),

            Actions\Action::make('page_settings')
                ->label('إعدادات الصفحة')
                ->icon('heroicon-o-adjustments-horizontal')
                ->color('gray')
                ->action(function () {
                    $s = $this->activeSection;
                    $this->s_hero_title_ar = Setting::get($s . '_hero_title_ar', '');
                    $this->s_hero_title_en = Setting::get($s . '_hero_title_en', '');
                    $this->s_hero_desc_ar  = Setting::get($s . '_hero_desc_ar', '');
                    $this->s_hero_desc_en  = Setting::get($s . '_hero_desc_en', '');
                    $this->showSettingsModal = true;
                }),
        ];
    }

    public function switchSection(string $section): void
    {
        $this->activeSection = $section;
    }

    // ---- Projects ----
    public function saveProject(): void
    {
        if ($this->editingProjectId) {
            Project::findOrFail($this->editingProjectId)->update($this->projectData);
            Notification::make()->title('تم التحديث ✅')->success()->send();
        } else {
            Project::create($this->projectData);
            Notification::make()->title('تم الإضافة ✅')->success()->send();
        }
        $this->showProjectModal = false;
        $this->editingProjectId = null;
        $this->projectData      = [];
    }

    public function editProject(int $id): void
    {
        $this->editingProjectId = $id;
        $this->projectData = Project::findOrFail($id)->toArray();
        $this->showProjectModal = true;
    }

    public function deleteProject(int $id): void
    {
        Project::findOrFail($id)->delete();
        Notification::make()->title('تم الحذف')->success()->send();
    }

    // ---- Programs ----
    public function saveProgram(): void
    {
        if ($this->editingProgramId) {
            Program::findOrFail($this->editingProgramId)->update($this->programData);
            Notification::make()->title('تم التحديث ✅')->success()->send();
        } else {
            Program::create($this->programData);
            Notification::make()->title('تم الإضافة ✅')->success()->send();
        }
        $this->showProgramModal = false;
        $this->editingProgramId = null;
        $this->programData      = [];
    }

    public function editProgram(int $id): void
    {
        $this->editingProgramId = $id;
        $this->programData = Program::findOrFail($id)->toArray();
        $this->showProgramModal = true;
    }

    public function deleteProgram(int $id): void
    {
        Program::findOrFail($id)->delete();
        Notification::make()->title('تم الحذف')->success()->send();
    }

    // ---- Settings ----
    public function saveSettings(): void
    {
        $s = $this->activeSection;
        Setting::set($s . '_hero_title_ar', $this->s_hero_title_ar);
        Setting::set($s . '_hero_title_en', $this->s_hero_title_en);
        Setting::set($s . '_hero_desc_ar',  $this->s_hero_desc_ar);
        Setting::set($s . '_hero_desc_en',  $this->s_hero_desc_en);
        $this->showSettingsModal = false;
        Notification::make()->title('تم حفظ الإعدادات ✅')->success()->send();
    }

    public function getView(): string
    {
        return 'filament.resources.campaign-resource.pages.list-campaigns';
    }
}
