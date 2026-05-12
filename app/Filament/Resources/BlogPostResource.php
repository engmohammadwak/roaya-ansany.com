<?php
namespace App\Filament\Resources;
use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'المدونة';
    protected static ?string $navigationGroup = 'إدارة الصفحات';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form {
        return $form->schema([
            Forms\Components\Tabs::make()->tabs([
                Forms\Components\Tabs\Tab::make('المعلومات الأساسية')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('title_ar')->label('العنوان (عربي)')->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('title_en')->label('العنوان (إنجليزي)'),
                        Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignorable: fn($record) => $record),
                        Forms\Components\TextInput::make('author')->label('الكاتب'),
                        Forms\Components\TextInput::make('category_ar')->label('التصنيف (عربي)'),
                        Forms\Components\TextInput::make('category_en')->label('التصنيف (إنجليزي)'),
                        Forms\Components\DateTimePicker::make('published_at')->label('تاريخ النشر'),
                        Forms\Components\Toggle::make('is_published')->label('منشور')->default(true),
                    ]),
                    Forms\Components\FileUpload::make('image')->label('الصورة الرئيسية')->image()->directory('blog')->columnSpanFull(),
                ]),
                Forms\Components\Tabs\Tab::make('المحتوى')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Textarea::make('excerpt_ar')->label('مقتطف (عربي)')->rows(3),
                        Forms\Components\Textarea::make('excerpt_en')->label('مقتطف (إنجليزي)')->rows(3),
                        Forms\Components\RichEditor::make('body_ar')->label('المحتوى (عربي)'),
                        Forms\Components\RichEditor::make('body_en')->label('المحتوى (إنجليزي)'),
                    ]),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')->label('الصورة'),
            Tables\Columns\TextColumn::make('title_ar')->label('العنوان')->searchable()->limit(50),
            Tables\Columns\TextColumn::make('author')->label('الكاتب'),
            Tables\Columns\IconColumn::make('is_published')->label('منشور')->boolean(),
            Tables\Columns\TextColumn::make('published_at')->label('تاريخ النشر')->dateTime('Y-m-d')->sortable(),
        ])->defaultSort('published_at','desc')
          ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array {
        return [
            'index'  => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit'   => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
