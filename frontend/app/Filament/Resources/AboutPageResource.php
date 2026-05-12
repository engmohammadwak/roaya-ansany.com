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
    protected static ?string $model = AboutPage::class;
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = 'صفحة من نحن';
    protected static ?string $navigationGroup = 'إدارة الصفحات';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('about_tabs')->tabs([

                Forms\Components\Tabs\Tab::make('Hero Section')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('hero_title_ar')->label('العنوان (عربي)')->required(),
                        Forms\Components\TextInput::make('hero_title_en')->label('العنوان (إنجليزي)'),
                        Forms\Components\Textarea::make('hero_subtitle_ar')->label('النص الفرعي (عربي)')->rows(3),
                        Forms\Components\Textarea::make('hero_subtitle_en')->label('النص الفرعي (إنجليزي)')->rows(3),
                    ]),
                    Forms\Components\FileUpload::make('hero_image')
                        ->label('صورة الهيرو')->image()->directory('about/hero'),
                ]),

                Forms\Components\Tabs\Tab::make('الإحصائيات')->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\TextInput::make('stat1_number')->label('الرقم 1'),
                        Forms\Components\TextInput::make('stat1_label_ar')->label('التسمية 1 (عربي)'),
                        Forms\Components\TextInput::make('stat1_label_en')->label('التسمية 1 (إنجليزي)'),
                        Forms\Components\TextInput::make('stat2_number')->label('الرقم 2'),
                        Forms\Components\TextInput::make('stat2_label_ar')->label('التسمية 2 (عربي)'),
                        Forms\Components\TextInput::make('stat2_label_en')->label('التسمية 2 (إنجليزي)'),
                        Forms\Components\TextInput::make('stat3_number')->label('الرقم 3'),
                        Forms\Components\TextInput::make('stat3_label_ar')->label('التسمية 3 (عربي)'),
                        Forms\Components\TextInput::make('stat3_label_en')->label('التسمية 3 (إنجليزي)'),
                        Forms\Components\TextInput::make('stat4_number')->label('الرقم 4'),
                        Forms\Components\TextInput::make('stat4_label_ar')->label('التسمية 4 (عربي)'),
                        Forms\Components\TextInput::make('stat4_label_en')->label('التسمية 4 (إنجليزي)'),
                    ]),
                ]),

                Forms\Components\Tabs\Tab::make('الرسالة والرؤية')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Textarea::make('mission_ar')->label('الرسالة (عربي)')->rows(4),
                        Forms\Components\Textarea::make('mission_en')->label('الرسالة (إنجليزي)')->rows(4),
                        Forms\Components\Textarea::make('vision_ar')->label('الرؤية (عربي)')->rows(4),
                        Forms\Components\Textarea::make('vision_en')->label('الرؤية (إنجليزي)')->rows(4),
                        Forms\Components\Textarea::make('goal_ar')->label('الهدف (عربي)')->rows(4),
                        Forms\Components\Textarea::make('goal_en')->label('الهدف (إنجليزي)')->rows(4),
                    ]),
                ]),

                Forms\Components\Tabs\Tab::make('من نحن - النص')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\RichEditor::make('about_text_ar')->label('النص (عربي)'),
                        Forms\Components\RichEditor::make('about_text_en')->label('النص (إنجليزي)'),
                    ]),
                    Forms\Components\FileUpload::make('about_image')
                        ->label('الصورة الجانبية')->image()->directory('about/content'),
                ]),

                Forms\Components\Tabs\Tab::make('زر الدعوة للتبرع')->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\TextInput::make('cta_text_ar')->label('نص الزر (عربي)'),
                        Forms\Components\TextInput::make('cta_text_en')->label('نص الزر (إنجليزي)'),
                        Forms\Components\TextInput::make('cta_url')->label('رابط الزر')->url(),
                    ]),
                ]),

            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('hero_title_ar')->label('عنوان الصفحة')->searchable(),
            Tables\Columns\TextColumn::make('updated_at')->label('آخر تعديل')->dateTime('Y-m-d H:i')->sortable(),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAboutPages::route('/'),
            'create' => Pages\CreateAboutPage::route('/create'),
            'edit'   => Pages\EditAboutPage::route('/{record}/edit'),
        ];
    }
}
