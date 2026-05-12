<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'المشاريع';
    protected static ?string $navigationGroup = 'إدارة الصفحات';
    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form {
        return $form->schema([
            Forms\Components\Tabs::make()->tabs([
                Forms\Components\Tabs\Tab::make('المعلومات الأساسية')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('title_ar')->label('الاسم (عربي)')->required(),
                        Forms\Components\TextInput::make('title_en')->label('الاسم (إنجليزي)'),
                        Forms\Components\TextInput::make('country_ar')->label('الدولة (عربي)'),
                        Forms\Components\TextInput::make('country_en')->label('الدولة (إنجليزي)'),
                        Forms\Components\TextInput::make('category_ar')->label('التصنيف (عربي)'),
                        Forms\Components\TextInput::make('category_en')->label('التصنيف (إنجليزي)'),
                        Forms\Components\TextInput::make('goal_amount')->label('مبلغ الهدف')->numeric()->default(0),
                        Forms\Components\TextInput::make('raised_amount')->label('المبلغ المجمّع')->numeric()->default(0),
                        Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
                        Forms\Components\Toggle::make('is_active')->label('نشط')->default(true),
                    ]),
                    Forms\Components\FileUpload::make('image')->label('الصورة')->image()->directory('projects')->columnSpanFull(),
                ]),
                Forms\Components\Tabs\Tab::make('المحتوى')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Textarea::make('description_ar')->label('الوصف (عربي)')->rows(3),
                        Forms\Components\Textarea::make('description_en')->label('الوصف (إنجليزي)')->rows(3),
                        Forms\Components\RichEditor::make('body_ar')->label('المحتوى الكامل (عربي)'),
                        Forms\Components\RichEditor::make('body_en')->label('المحتوى الكامل (إنجليزي)'),
                    ]),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')->label('الصورة'),
            Tables\Columns\TextColumn::make('title_ar')->label('المشروع')->searchable(),
            Tables\Columns\TextColumn::make('country_ar')->label('الدولة'),
            Tables\Columns\TextColumn::make('goal_amount')->label('الهدف')->money('USD'),
            Tables\Columns\TextColumn::make('raised_amount')->label('المجمّع')->money('USD'),
            Tables\Columns\IconColumn::make('is_active')->label('نشط')->boolean(),
        ])->reorderable('sort_order')->defaultSort('sort_order')
          ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array {
        return [
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
