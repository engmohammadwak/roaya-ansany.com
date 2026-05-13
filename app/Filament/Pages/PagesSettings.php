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
    protected static ?string $navigationLabel = '\u0625\u0639\u062f\u0627\u062f\u0627\u062a \u0627\u0644\u0635\u0641\u062d\u0627\u062a';
    protected static ?string $navigationGroup = '\u0625\u062f\u0627\u0631\u0629 \u0627\u0644\u0635\u0641\u062d\u0627\u062a';
    protected static ?string $title           = '\u0625\u0639\u062f\u0627\u062f\u0627\u062a \u0635\u0641\u062d\u0627\u062a \u0627\u0644\u062d\u0645\u0644\u0627\u062a \u0648\u0627\u0644\u0645\u0634\u0627\u0631\u064a\u0639 \u0648\u0627\u0644\u0628\u0631\u0627\u0645\u062c';
    protected static ?int    $navigationSort  = 10;
    protected static string  $view            = 'filament.pages.pages-settings';

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

                    Tabs\Tab::make('\ud83d\udce3 \u0627\u0644\u062d\u0645\u0644\u0627\u062a')->schema([
                        Section::make('\u0646\u0635 Hero \u0635\u0641\u062d\u0629 \u0627\u0644\u062d\u0645\u0644\u0627\u062a')->schema([
                            Grid::make(2)->schema([
                                TextInput::make('campaigns_hero_title_ar')
                                    ->label('\u0627\u0644\u0639\u0646\u0648\u0627\u0646 (\u0639\u0631\u0628\u064a)')
                                    ->placeholder('\u0634\u0627\u0631\u0643 \u0641\u064a \u0635\u0646\u0639 \u0627\u0644\u0623\u0645\u0644'),
                                TextInput::make('campaigns_hero_title_en')
                                    ->label('\u0627\u0644\u0639\u0646\u0648\u0627\u0646 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)')
                                    ->placeholder('Be Part of Making Hope'),
                                Textarea::make('campaigns_hero_desc_ar')
                                    ->label('\u0627\u0644\u0648\u0635\u0641 (\u0639\u0631\u0628\u064a)')->rows(3),
                                Textarea::make('campaigns_hero_desc_en')
                                    ->label('\u0627\u0644\u0648\u0635\u0641 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)')->rows(3),
                            ]),
                        ]),
                    ]),

                    Tabs\Tab::make('\ud83c\udf31 \u0627\u0644\u0645\u0634\u0627\u0631\u064a\u0639')->schema([
                        Section::make('\u0646\u0635 Hero \u0635\u0641\u062d\u0629 \u0627\u0644\u0645\u0634\u0627\u0631\u064a\u0639')->schema([
                            Grid::make(2)->schema([
                                TextInput::make('projects_hero_title_ar')
                                    ->label('\u0627\u0644\u0639\u0646\u0648\u0627\u0646 (\u0639\u0631\u0628\u064a)')
                                    ->placeholder('\u0645\u0634\u0627\u0631\u064a\u0639\u0646\u0627'),
                                TextInput::make('projects_hero_title_en')
                                    ->label('\u0627\u0644\u0639\u0646\u0648\u0627\u0646 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)')
                                    ->placeholder('Our Projects'),
                                Textarea::make('projects_hero_desc_ar')
                                    ->label('\u0627\u0644\u0648\u0635\u0641 (\u0639\u0631\u0628\u064a)')->rows(3),
                                Textarea::make('projects_hero_desc_en')
                                    ->label('\u0627\u0644\u0648\u0635\u0641 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)')->rows(3),
                            ]),
                        ]),
                    ]),

                    Tabs\Tab::make('\ud83d\udccc \u0627\u0644\u0628\u0631\u0627\u0645\u062c')->schema([
                        Section::make('\u0646\u0635 Hero \u0635\u0641\u062d\u0629 \u0627\u0644\u0628\u0631\u0627\u0645\u062c')->schema([
                            Grid::make(2)->schema([
                                TextInput::make('programs_hero_title_ar')
                                    ->label('\u0627\u0644\u0639\u0646\u0648\u0627\u0646 (\u0639\u0631\u0628\u064a)')
                                    ->placeholder('\u0628\u0631\u0627\u0645\u062c\u0646\u0627'),
                                TextInput::make('programs_hero_title_en')
                                    ->label('\u0627\u0644\u0639\u0646\u0648\u0627\u0646 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)')
                                    ->placeholder('Our Programs'),
                                Textarea::make('programs_hero_desc_ar')
                                    ->label('\u0627\u0644\u0648\u0635\u0641 (\u0639\u0631\u0628\u064a)')->rows(3),
                                Textarea::make('programs_hero_desc_en')
                                    ->label('\u0627\u0644\u0648\u0635\u0641 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)')->rows(3),
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
            ->title('\u062a\u0645 \u0627\u0644\u062d\u0641\u0638 \u0628\u0646\u062c\u0627\u062d \u2705')
            ->success()
            ->send();
    }
}
