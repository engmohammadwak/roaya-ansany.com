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

    // ---- active tab ----
    public string $activeSection = 'campaigns';

    // ---- modals state ----
    public bool   $showProjectModal  = false;
    public bool   $showProgramModal  = false;
    public bool   $showSettingsModal = false;
    public ?int   $editingProjectId  = null;
    public ?int   $editingProgramId  = null;
    public array  $projectData       = [];
    public array  $programData       = [];
    public array  $settingsData      = [];

    protected function getHeaderActions(): array
    {
        return [
            // ---- New Campaign ----
            Actions\CreateAction::make()
                ->label('إضافة حملة')
                ->visible(fn () => $this->activeSection === 'campaigns'),

            // ---- New Project ----
            Actions\Action::make('new_project')
                ->label('إضافة مشروع')
                ->icon('heroicon-o-plus')
                ->visible(fn () => $this->activeSection === 'projects')
                ->action(function () {
                    $this->editingProjectId = null;
                    $this->projectData = [];
                    $this->showProjectModal = true;
                }),

            // ---- New Program ----
            Actions\Action::make('new_program')
                ->label('إضافة برنامج')
                ->icon('heroicon-o-plus')
                ->visible(fn () => $this->activeSection === 'programs')
                ->action(function () {
                    $this->editingProgramId = null;
                    $this->programData = [];
                    $this->showProgramModal = true;
                }),

            // ---- Page Settings ----
            Actions\Action::make('page_settings')
                ->label('إعدادات الصفحة')
                ->icon('heroicon-o-adjustments-horizontal')
                ->color('gray')
                ->action(function () {
                    $section = $this->activeSection;
                    $this->settingsData = [
                        'hero_title_ar' => Setting::get($section.'_hero_title_ar', ''),
                        'hero_title_en' => Setting::get($section.'_hero_title_en', ''),
                        'hero_desc_ar'  => Setting::get($section.'_hero_desc_ar', ''),
                        'hero_desc_en'  => Setting::get($section.'_hero_desc_en', ''),
                    ];
                    $this->showSettingsModal = true;
                }),
        ];
    }

    // ---- switch tab ----
    public function switchSection(string $section): void
    {
        $this->activeSection = $section;
    }

    // ---- save project ----
    public function saveProject(): void
    {
        $data = $this->projectData;
        if ($this->editingProjectId) {
            Project::findOrFail($this->editingProjectId)->update($data);
            Notification::make()->title('تم التحديث ✅')->success()->send();
        } else {
            Project::create($data);
            Notification::make()->title('تم الإضافة ✅')->success()->send();
        }
        $this->showProjectModal  = false;
        $this->editingProjectId  = null;
        $this->projectData       = [];
    }

    public function editProject(int $id): void
    {
        $p = Project::findOrFail($id);
        $this->editingProjectId = $id;
        $this->projectData = $p->toArray();
        $this->showProjectModal = true;
    }

    public function deleteProject(int $id): void
    {
        Project::findOrFail($id)->delete();
        Notification::make()->title('تم الحذف')->success()->send();
    }

    // ---- save program ----
    public function saveProgram(): void
    {
        $data = $this->programData;
        if ($this->editingProgramId) {
            Program::findOrFail($this->editingProgramId)->update($data);
            Notification::make()->title('تم التحديث ✅')->success()->send();
        } else {
            Program::create($data);
            Notification::make()->title('تم الإضافة ✅')->success()->send();
        }
        $this->showProgramModal  = false;
        $this->editingProgramId  = null;
        $this->programData       = [];
    }

    public function editProgram(int $id): void
    {
        $p = Program::findOrFail($id);
        $this->editingProgramId = $id;
        $this->programData = $p->toArray();
        $this->showProgramModal = true;
    }

    public function deleteProgram(int $id): void
    {
        Program::findOrFail($id)->delete();
        Notification::make()->title('تم الحذف')->success()->send();
    }

    // ---- save settings ----
    public function saveSettings(): void
    {
        $section = $this->activeSection;
        foreach ($this->settingsData as $key => $value) {
            Setting::set($section.'_'.$key, $value ?? '');
        }
        $this->showSettingsModal = false;
        Notification::make()->title('تم حفظ الإعدادات ✅')->success()->send();
    }

    public function getView(): string
    {
        return 'filament.resources.campaign-resource.pages.list-campaigns';
    }
}
