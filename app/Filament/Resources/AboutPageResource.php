<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutPageResource\Pages;
use App\Models\AboutPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutPageResource extends Resource
{
    protected static ?string $model             = AboutPage::class;
    protected static ?string $navigationIcon    = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel   = 'صفحة من نحن';
    protected static ?string $navigationGroup   = 'إدارة الصفحات';
    protected static ?int    $navigationSort    = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('about_tabs')->tabs([

                // =================== HERO ===================
                Forms\Components\Tabs\Tab::make('🏠 Hero')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('hero_title_ar')
                            ->label('عنوان الصفحة (عربي)')
                            ->required(),
                        Forms\Components\TextInput::make('hero_title_en')
                            ->label('عنوان الصفحة (إنجليزي)'),
                        Forms\Components\Textarea::make('hero_description_ar')
                            ->label('وصف الهيرو (عربي)')->rows(4),
                        Forms\Components\Textarea::make('hero_description_en')
                            ->label('وصف الهيرو (إنجليزي)')->rows(4),
                    ]),

                    Forms\Components\Section::make('🏷️ البطاقة الصغيرة (Hero Badge)')->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('hero_badge_title_ar')
                                ->label('العنوان الرئيسي (عربي)')
                                ->placeholder('نسعى إلى مدّ يد العون للمحتاجين والمنكوبين'),
                            Forms\Components\TextInput::make('hero_badge_title_en')
                                ->label('العنوان الرئيسي (إنجليزي)')
                                ->placeholder('We reach out to those in need'),
                            Forms\Components\TextInput::make('hero_badge_subtitle_ar')
                                ->label('العنوان الفرعي (عربي)')
                                ->placeholder('أينما كانوا'),
                            Forms\Components\TextInput::make('hero_badge_subtitle_en')
                                ->label('العنوان الفرعي (إنجليزي)')
                                ->placeholder('Wherever they are'),
                        ]),
                    ]),

                    Forms\Components\FileUpload::make('hero_image_1')
                        ->label('صورة الهيرو')
                        ->image()
                        ->directory('about/hero')
                        ->imagePreviewHeight('200')
                        ->columnSpanFull(),
                ]),

                // =================== VISION & GOALS ===================
                Forms\Components\Tabs\Tab::make('🎯 الرؤية و الأهداف')->schema([

                    Forms\Components\Section::make('وصف قسم الرؤية (النص المركزي)')->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Textarea::make('vision_section_desc_ar')
                                ->label('(عربي)')->rows(3),
                            Forms\Components\Textarea::make('vision_section_desc_en')
                                ->label('(إنجليزي)')->rows(3),
                        ]),
                    ]),

                    Forms\Components\Section::make('🔵 بطاقة رؤيتنا (Vision)')->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Textarea::make('vision_text_ar')
                                ->label('نص الرؤية (عربي)')->rows(4),
                            Forms\Components\Textarea::make('vision_text_en')
                                ->label('نص الرؤية (إنجليزي)')->rows(4),
                        ]),
                    ]),

                    Forms\Components\Section::make('🟢 بطاقة أهدافنا (Goals) — قائمة نقاط')->schema([
                        Forms\Components\Repeater::make('goal_points_ar')
                            ->label('نقاط الأهداف (عربي)')
                            ->schema([
                                Forms\Components\TextInput::make('item')->label('النقطة')->required(),
                            ])
                            ->addActionLabel('➕ إضافة نقطة')
                            ->columnSpanFull()
                            ->reorderable()
                            ->collapsible(),

                        Forms\Components\Repeater::make('goal_points_en')
                            ->label('نقاط الأهداف (إنجليزي)')
                            ->schema([
                                Forms\Components\TextInput::make('item')->label('Point')->required(),
                            ])
                            ->addActionLabel('+ Add Point')
                            ->columnSpanFull()
                            ->reorderable()
                            ->collapsible(),
                    ]),

                    Forms\Components\Section::make('🟠 بطاقة رسالتنا (Mission)')->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Textarea::make('mission_text_ar')
                                ->label('نص الرسالة (عربي)')->rows(4),
                            Forms\Components\Textarea::make('mission_text_en')
                                ->label('نص الرسالة (إنجليزي)')->rows(4),
                        ]),
                    ]),

                ]),

                // =================== STORY ===================
                Forms\Components\Tabs\Tab::make('📍 قسم من نحن')->schema([

                    Forms\Components\Section::make('الفقرة الأولى')->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Textarea::make('story_paragraph_1_ar')
                                ->label('(عربي)')->rows(4),
                            Forms\Components\Textarea::make('story_paragraph_1_en')
                                ->label('(إنجليزي)')->rows(4),
                        ]),
                    ]),

                    Forms\Components\Section::make('الفقرة الثانية')->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Textarea::make('story_paragraph_2_ar')
                                ->label('(عربي)')->rows(4),
                            Forms\Components\Textarea::make('story_paragraph_2_en')
                                ->label('(إنجليزي)')->rows(4),
                        ]),
                    ]),

                    Forms\Components\Section::make('نص الدعوة للتبرع')->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Textarea::make('story_cta_text_ar')
                                ->label('(عربي)')->rows(3),
                            Forms\Components\Textarea::make('story_cta_text_en')
                                ->label('(إنجليزي)')->rows(3),
                        ]),
                    ]),

                    Forms\Components\FileUpload::make('story_image')
                        ->label('صورة قسم من نحن')
                        ->image()
                        ->directory('about/story')
                        ->imagePreviewHeight('200')
                        ->columnSpanFull(),

                ]),

            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hero_title_ar')
                    ->label('عنوان الصفحة'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخر تعديل')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAboutPages::route('/'),
            'edit'  => Pages\EditAboutPage::route('/{record}/edit'),
        ];
    }

    public static function getNavigationUrl(): string
    {
        $record = AboutPage::first();
        if ($record) {
            return static::getUrl('edit', ['record' => $record->id]);
        }
        return parent::getNavigationUrl();
    }
}
