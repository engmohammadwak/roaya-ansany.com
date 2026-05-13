<?php

namespace App\Filament\Resources\CampaignResource\Pages;

use App\Filament\Resources\CampaignResource;
use App\Models\Program;
use App\Models\Project;
use App\Models\Setting;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;
use Livewire\Attributes\On;

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
                ->label('\u0625\u0636\u0627\u0641\u0629 \u062d\u0645\u0644\u0629')
                ->visible(fn () => $this->activeSection === 'campaigns'),

            // ---- New Project ----
            Actions\Action::make('new_project')
                ->label('\u0625\u0636\u0627\u0641\u0629 \u0645\u0634\u0631\u0648\u0639')
                ->icon('heroicon-o-plus')
                ->visible(fn () => $this->activeSection === 'projects')
                ->action(function () {
                    $this->editingProjectId = null;
                    $this->projectData = [];
                    $this->showProjectModal = true;
                }),

            // ---- New Program ----
            Actions\Action::make('new_program')
                ->label('\u0625\u0636\u0627\u0641\u0629 \u0628\u0631\u0646\u0627\u0645\u062c')
                ->icon('heroicon-o-plus')
                ->visible(fn () => $this->activeSection === 'programs')
                ->action(function () {
                    $this->editingProgramId = null;
                    $this->programData = [];
                    $this->showProgramModal = true;
                }),

            // ---- Page Settings ----
            Actions\Action::make('page_settings')
                ->label('\u0625\u0639\u062f\u0627\u062f\u0627\u062a \u0627\u0644\u0635\u0641\u062d\u0629')
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
            Notification::make()->title('\u062a\u0645 \u0627\u0644\u062a\u062d\u062f\u064a\u062b \u2705')->success()->send();
        } else {
            Project::create($data);
            Notification::make()->title('\u062a\u0645 \u0627\u0644\u0625\u0636\u0627\u0641\u0629 \u2705')->success()->send();
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
        Notification::make()->title('\u062a\u0645 \u0627\u0644\u062d\u0630\u0641')->success()->send();
    }

    // ---- save program ----
    public function saveProgram(): void
    {
        $data = $this->programData;
        if ($this->editingProgramId) {
            Program::findOrFail($this->editingProgramId)->update($data);
            Notification::make()->title('\u062a\u0645 \u0627\u0644\u062a\u062d\u062f\u064a\u062b \u2705')->success()->send();
        } else {
            Program::create($data);
            Notification::make()->title('\u062a\u0645 \u0627\u0644\u0625\u0636\u0627\u0641\u0629 \u2705')->success()->send();
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
        Notification::make()->title('\u062a\u0645 \u0627\u0644\u062d\u0630\u0641')->success()->send();
    }

    // ---- save settings ----
    public function saveSettings(): void
    {
        $section = $this->activeSection;
        foreach ($this->settingsData as $key => $value) {
            Setting::set($section.'_'.$key, $value ?? '');
        }
        $this->showSettingsModal = false;
        Notification::make()->title('\u062a\u0645 \u062d\u0641\u0638 \u0627\u0644\u0625\u0639\u062f\u0627\u062f\u0627\u062a \u2705')->success()->send();
    }

    protected function getView(): string
    {
        return 'filament.resources.campaign-resource.pages.list-campaigns';
    }
}
