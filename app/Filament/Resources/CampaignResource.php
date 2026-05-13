<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampaignResource\Pages;
use App\Models\Campaign;
use App\Models\Program;
use App\Models\Project;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CampaignResource extends Resource
{
    protected static ?string $model             = Campaign::class;
    protected static ?string $navigationIcon    = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel   = '\u0627\u0644\u062d\u0645\u0644\u0627\u062a \u0648\u0627\u0644\u0645\u0634\u0627\u0631\u064a\u0639 \u0648\u0627\u0644\u0628\u0631\u0627\u0645\u062c';
    protected static ?string $navigationGroup   = '\u0625\u062f\u0627\u0631\u0629 \u0627\u0644\u0635\u0641\u062d\u0627\u062a';
    protected static ?string $modelLabel        = '\u062d\u0645\u0644\u0629';
    protected static ?string $pluralModelLabel  = '\u0627\u0644\u062d\u0645\u0644\u0627\u062a';
    protected static ?int    $navigationSort    = 3;

    // ============================================================
    // CAMPAIGN FORM
    // ============================================================
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('translations')->tabs([
                Forms\Components\Tabs\Tab::make('\u0627\u0644\u0639\u0631\u0628\u064a\u0629')->schema([
                    Forms\Components\TextInput::make('title_ar')->label('\u0627\u0644\u0639\u0646\u0648\u0627\u0646 \u0628\u0627\u0644\u0639\u0631\u0628\u064a\u0629')->required(),
                    Forms\Components\Textarea::make('description_ar')->label('\u0627\u0644\u0648\u0635\u0641 \u0628\u0627\u0644\u0639\u0631\u0628\u064a\u0629')->required()->rows(4),
                ]),
                Forms\Components\Tabs\Tab::make('English')->schema([
                    Forms\Components\TextInput::make('title_en')
                        ->label('Title in English')->required()
                        ->live(debounce: 600)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                    Forms\Components\Textarea::make('description_en')->label('Description in English')->required()->rows(4),
                ]),
            ])->columnSpanFull(),

            Forms\Components\TextInput::make('slug')
                ->label('Slug (\u0631\u0627\u0628\u0637 SEO)')
                ->helperText('\u064a\u0648\u0644\u062f \u062a\u0644\u0642\u0627\u0626\u064a\u064b\u0627 \u0645\u0646 \u0627\u0644\u0639\u0646\u0648\u0627\u0646 \u0627\u0644\u0625\u0646\u062c\u0644\u064a\u0632\u064a')
                ->unique(Campaign::class, 'slug', ignoreRecord: true)
                ->columnSpanFull()->nullable(),

            FileUpload::make('image')
                ->label('\u0635\u0648\u0631\u0629 \u0627\u0644\u062d\u0645\u0644\u0629')->image()->disk('public')->directory('campaigns')
                ->visibility('public')->imagePreviewHeight('280')->imageEditor()
                ->deletable(true)->openable(true)->downloadable(true)
                ->maxSize(102400)->acceptedFileTypes(['image/jpeg','image/png','image/webp','image/gif'])
                ->columnSpanFull()->uploadingMessage('\u062c\u0627\u0631\u064a \u0631\u0641\u0639 \u0627\u0644\u0635\u0648\u0631\u0629...')
                ->helperText('\u0627\u0644\u062d\u062f \u0627\u0644\u0623\u0642\u0635\u0649 100 \u0645\u064a\u062c\u0627\u0628\u0627\u064a\u062a')
                ->afterStateHydrated(function (FileUpload $component, $state) {
                    if (is_string($state) && $state !== '') $component->state([$state => $state]);
                })
                ->dehydrateStateUsing(function ($state) {
                    if (is_array($state) && count($state) > 0) return array_values($state)[0];
                    return null;
                }),

            Forms\Components\TextInput::make('target_amount')->label('\u0627\u0644\u0645\u0628\u0644\u063a \u0627\u0644\u0645\u0633\u062a\u0647\u062f\u0641')->numeric()->required(),
            Forms\Components\TextInput::make('collected_amount')->label('\u0627\u0644\u0645\u0628\u0644\u063a \u0627\u0644\u0645\u062c\u0645\u0648\u0639')->numeric()->default(0),
            Forms\Components\DatePicker::make('end_date')->label('\u062a\u0627\u0631\u064a\u062e \u0627\u0644\u0627\u0646\u062a\u0647\u0627\u0621'),
            Forms\Components\Toggle::make('is_active')->label('\u0646\u0634\u0637\u0629')->default(true),
        ]);
    }

    // ============================================================
    // CAMPAIGN TABLE (default — used in ListCampaigns)
    // ============================================================
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('\u0627\u0644\u0635\u0648\u0631\u0629')->disk('public')->height(60)->width(80),
                Tables\Columns\TextColumn::make('title_ar')->label('\u0627\u0644\u0639\u0646\u0648\u0627\u0646')->searchable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->copyable()->color('primary'),
                Tables\Columns\TextColumn::make('target_amount')->label('\u0627\u0644\u0645\u0633\u062a\u0647\u062f\u0641')->money('USD'),
                Tables\Columns\TextColumn::make('collected_amount')->label('\u0627\u0644\u0645\u062c\u0645\u0648\u0639')->money('USD'),
                Tables\Columns\IconColumn::make('is_active')->label('\u0646\u0634\u0637\u0629')->boolean(),
                Tables\Columns\TextColumn::make('end_date')->label('\u064a\u0646\u062a\u0647\u064a')->date(),
            ])
            ->actions([
                Tables\Actions\Action::make('view_site')
                    ->label('\u0639\u0631\u0636 \u0641\u064a \u0627\u0644\u0645\u0648\u0642\u0639')
                    ->icon('heroicon-o-eye')->color('gray')
                    ->url(fn (Campaign $record) => $record->slug ? url('ar/campaigns/'.$record->slug) : null)
                    ->hidden(fn (Campaign $record) => !$record->slug)
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    // ============================================================
    // PROJECT FORM
    // ============================================================
    public static function projectForm(): array
    {
        return [
            Forms\Components\Tabs::make()->tabs([
                Forms\Components\Tabs\Tab::make('\u0627\u0644\u0645\u0639\u0644\u0648\u0645\u0627\u062a \u0627\u0644\u0623\u0633\u0627\u0633\u064a\u0629')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('title_ar')->label('\u0627\u0644\u0627\u0633\u0645 (\u0639\u0631\u0628\u064a)')->required(),
                        Forms\Components\TextInput::make('title_en')->label('\u0627\u0644\u0627\u0633\u0645 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)'),
                        Forms\Components\TextInput::make('country_ar')->label('\u0627\u0644\u062f\u0648\u0644\u0629 (\u0639\u0631\u0628\u064a)'),
                        Forms\Components\TextInput::make('country_en')->label('\u0627\u0644\u062f\u0648\u0644\u0629 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)'),
                        Forms\Components\TextInput::make('category_ar')->label('\u0627\u0644\u062a\u0635\u0646\u064a\u0641 (\u0639\u0631\u0628\u064a)'),
                        Forms\Components\TextInput::make('category_en')->label('\u0627\u0644\u062a\u0635\u0646\u064a\u0641 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)'),
                        Forms\Components\TextInput::make('goal_amount')->label('\u0645\u0628\u0644\u063a \u0627\u0644\u0647\u062f\u0641')->numeric()->default(0),
                        Forms\Components\TextInput::make('raised_amount')->label('\u0627\u0644\u0645\u0628\u0644\u063a \u0627\u0644\u0645\u062c\u0645\u0651\u0639')->numeric()->default(0),
                        Forms\Components\TextInput::make('sort_order')->label('\u0627\u0644\u062a\u0631\u062a\u064a\u0628')->numeric()->default(0),
                        Forms\Components\Toggle::make('is_active')->label('\u0646\u0634\u0637')->default(true),
                    ]),
                    Forms\Components\FileUpload::make('image')->label('\u0627\u0644\u0635\u0648\u0631\u0629')->image()->directory('projects')->columnSpanFull(),
                ]),
                Forms\Components\Tabs\Tab::make('\u0627\u0644\u0645\u062d\u062a\u0648\u0649')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Textarea::make('description_ar')->label('\u0627\u0644\u0648\u0635\u0641 (\u0639\u0631\u0628\u064a)')->rows(3),
                        Forms\Components\Textarea::make('description_en')->label('\u0627\u0644\u0648\u0635\u0641 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)')->rows(3),
                        Forms\Components\RichEditor::make('body_ar')->label('\u0627\u0644\u0645\u062d\u062a\u0648\u0649 \u0627\u0644\u0643\u0627\u0645\u0644 (\u0639\u0631\u0628\u064a)'),
                        Forms\Components\RichEditor::make('body_en')->label('\u0627\u0644\u0645\u062d\u062a\u0648\u0649 \u0627\u0644\u0643\u0627\u0645\u0644 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)'),
                    ]),
                ]),
            ])->columnSpanFull(),
        ];
    }

    // ============================================================
    // PROGRAM FORM
    // ============================================================
    public static function programForm(): array
    {
        return [
            Forms\Components\Tabs::make()->tabs([
                Forms\Components\Tabs\Tab::make('\u0627\u0644\u0645\u0639\u0644\u0648\u0645\u0627\u062a \u0627\u0644\u0623\u0633\u0627\u0633\u064a\u0629')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('title_ar')->label('\u0627\u0644\u0627\u0633\u0645 (\u0639\u0631\u0628\u064a)')->required(),
                        Forms\Components\TextInput::make('title_en')->label('\u0627\u0644\u0627\u0633\u0645 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)'),
                        Forms\Components\TextInput::make('category_ar')->label('\u0627\u0644\u062a\u0635\u0646\u064a\u0641 (\u0639\u0631\u0628\u064a)'),
                        Forms\Components\TextInput::make('category_en')->label('\u0627\u0644\u062a\u0635\u0646\u064a\u0641 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)'),
                        Forms\Components\TextInput::make('icon')->label('\u0627\u0644\u0623\u064a\u0642\u0648\u0646\u0629 (Emoji)'),
                        Forms\Components\TextInput::make('sort_order')->label('\u0627\u0644\u062a\u0631\u062a\u064a\u0628')->numeric()->default(0),
                        Forms\Components\Toggle::make('is_active')->label('\u0646\u0634\u0637')->default(true),
                    ]),
                    Forms\Components\FileUpload::make('image')->label('\u0627\u0644\u0635\u0648\u0631\u0629')->image()->directory('programs')->columnSpanFull(),
                ]),
                Forms\Components\Tabs\Tab::make('\u0627\u0644\u0645\u062d\u062a\u0648\u0649')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Textarea::make('description_ar')->label('\u0627\u0644\u0648\u0635\u0641 (\u0639\u0631\u0628\u064a)')->rows(3),
                        Forms\Components\Textarea::make('description_en')->label('\u0627\u0644\u0648\u0635\u0641 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)')->rows(3),
                        Forms\Components\RichEditor::make('body_ar')->label('\u0627\u0644\u0645\u062d\u062a\u0648\u0649 \u0627\u0644\u0643\u0627\u0645\u0644 (\u0639\u0631\u0628\u064a)'),
                        Forms\Components\RichEditor::make('body_en')->label('\u0627\u0644\u0645\u062d\u062a\u0648\u0649 \u0627\u0644\u0643\u0627\u0645\u0644 (\u0625\u0646\u062c\u0644\u064a\u0632\u064a)'),
                    ]),
                ]),
            ])->columnSpanFull(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit'   => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
