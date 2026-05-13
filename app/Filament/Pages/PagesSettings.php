<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class PagesSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon  = 'heroicon-o-adjustments-horizontal';
    protected static ?string $navigationLabel = 'إعدادات الصفحات';
    protected static ?string $navigationGroup = 'إدارة الصفحات';
    protected static ?string $title           = 'إعدادات صفحات الحملات والمشاريع والبرامج';
    protected static ?int    $navigationSort  = 10;
    protected static string  $view            = 'filament.pages.pages-settings';

    // مخفية من القائمة — الإعدادات موجودة داخل صفحة الحملات
    protected static bool $shouldRegisterNavigation = false;

    public array $data = [];

    public function mount(): void
    {
        $keys = [
            'campaigns_hero_title_ar', 'campaigns_hero_title_en',
            'campaigns_hero_desc_ar',  'campaigns_hero_desc_en',
            'projects_hero_title_ar',  'projects_hero_title_en',
            'projects_hero_desc_ar',   'projects_hero_desc_en',
            'programs_hero_title_ar',  'programs_hero_title_en',
            'programs_hero_desc_ar',   'programs_hero_desc_en',
        ];

        $filled = [];
        foreach ($keys as $key) {
            $filled[$key] = Setting::get($key, '');
        }

        $this->form->fill($filled);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('pages_tabs')->tabs([

                    Tabs\Tab::make('📣 الحملات')->schema([
                        Section::make('نص Hero صفحة الحملات')->schema([
                            Grid::make(2)->schema([
                                TextInput::make('campaigns_hero_title_ar')
                                    ->label('العنوان (عربي)')
                                    ->placeholder('شارك في صنع الأمل'),
                                TextInput::make('campaigns_hero_title_en')
                                    ->label('العنوان (إنجليزي)')
                                    ->placeholder('Be Part of Making Hope'),
                                Textarea::make('campaigns_hero_desc_ar')
                                    ->label('الوصف (عربي)')->rows(3),
                                Textarea::make('campaigns_hero_desc_en')
                                    ->label('الوصف (إنجليزي)')->rows(3),
                            ]),
                        ]),
                    ]),

                    Tabs\Tab::make('🌱 المشاريع')->schema([
                        Section::make('نص Hero صفحة المشاريع')->schema([
                            Grid::make(2)->schema([
                                TextInput::make('projects_hero_title_ar')
                                    ->label('العنوان (عربي)')
                                    ->placeholder('مشاريعنا'),
                                TextInput::make('projects_hero_title_en')
                                    ->label('العنوان (إنجليزي)')
                                    ->placeholder('Our Projects'),
                                Textarea::make('projects_hero_desc_ar')
                                    ->label('الوصف (عربي)')->rows(3),
                                Textarea::make('projects_hero_desc_en')
                                    ->label('الوصف (إنجليزي)')->rows(3),
                            ]),
                        ]),
                    ]),

                    Tabs\Tab::make('📌 البرامج')->schema([
                        Section::make('نص Hero صفحة البرامج')->schema([
                            Grid::make(2)->schema([
                                TextInput::make('programs_hero_title_ar')
                                    ->label('العنوان (عربي)')
                                    ->placeholder('برامجنا'),
                                TextInput::make('programs_hero_title_en')
                                    ->label('العنوان (إنجليزي)')
                                    ->placeholder('Our Programs'),
                                Textarea::make('programs_hero_desc_ar')
                                    ->label('الوصف (عربي)')->rows(3),
                                Textarea::make('programs_hero_desc_en')
                                    ->label('الوصف (إنجليزي)')->rows(3),
                            ]),
                        ]),
                    ]),

                ])->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        foreach ($data as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        Notification::make()
            ->title('تم الحفظ بنجاح ✅')
            ->success()
            ->send();
    }
}
