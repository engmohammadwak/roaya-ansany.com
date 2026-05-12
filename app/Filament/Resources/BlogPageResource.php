<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BlogPageResource\Pages;
use App\Models\BlogPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlogPageResource extends Resource
{
    protected static ?string $model = BlogPage::class;
    protected static ?string $navigationIcon  = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'المدونة';
    protected static ?string $navigationLabel = 'إعدادات صفحة المدونة';
    protected static ?int    $navigationSort  = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('قسم الهيرو (اليسار)')
                ->schema([
                    Forms\Components\TextInput::make('hero_title_ar')->label('عنوان الصفحة (عربي)'),
                    Forms\Components\TextInput::make('hero_title_en')->label('عنوان الصفحة (إنجليزي)'),
                    Forms\Components\TextInput::make('hero_sub_ar')->label('عنوان البطاقة (عربي)'),
                    Forms\Components\TextInput::make('hero_sub_en')->label('عنوان البطاقة (إنجليزي)'),
                    Forms\Components\Textarea::make('hero_para_ar')->label('نص البطاقة (عربي)')->rows(3),
                    Forms\Components\Textarea::make('hero_para_en')->label('نص البطاقة (إنجليزي)')->rows(3),
                    Forms\Components\TextInput::make('hero_cats_ar')->label('تيجات الهيرو (عربي) — فصل بفاصلة')
                        ->helperText('مثال: حكاية,حياة,كرم'),
                    Forms\Components\TextInput::make('hero_cats_en')->label('تيجات الهيرو (إنجليزي) — فصل بفاصلة')
                        ->helperText('Example: Story,Life,Generosity'),
                ])->columns(2),

            Forms\Components\Section::make('قسم المقالات')
                ->schema([
                    Forms\Components\TextInput::make('section_label_ar')->label('تسمية صغيرة (عربي)'),
                    Forms\Components\TextInput::make('section_label_en')->label('تسمية صغيرة (إنجليزي)'),
                    Forms\Components\TextInput::make('section_title_ar')->label('عنوان القسم (عربي)'),
                    Forms\Components\TextInput::make('section_title_en')->label('عنوان القسم (إنجليزي)'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('section_title_ar')->label('عنوان القسم'),
                Tables\Columns\TextColumn::make('updated_at')->label('آخر تعديل')->dateTime()->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPages::route('/'),
            'edit'  => Pages\EditBlogPage::route('/{record}/edit'),
        ];
    }
}
