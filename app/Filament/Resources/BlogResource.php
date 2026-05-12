<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;
    protected static ?string $navigationIcon  = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'المدونة';
    protected static ?string $navigationLabel = 'المقالات';
    protected static ?int    $navigationSort  = 1;

    public static function getNavigationBadge(): ?string {
        return (string) Blog::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('معلومات المقال')
                ->schema([
                    Forms\Components\TextInput::make('title_ar')
                        ->label('العنوان (عربي)')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) =>
                            $set('slug', Str::slug($state))
                        ),
                    Forms\Components\TextInput::make('title_en')
                        ->label('العنوان (إنجليزي)'),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->unique(Blog::class, 'slug', ignoreRecord: true),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('تاريخ النشر')
                        ->default(now()),
                    Forms\Components\Toggle::make('is_published')
                        ->label('منشور')
                        ->default(true)
                        ->onColor('success'),
                    Forms\Components\FileUpload::make('image')
                        ->label('الصورة الرئيسية')
                        ->image()
                        ->directory('news')
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('ملخص المقال')
                ->schema([
                    Forms\Components\Textarea::make('excerpt_ar')->label('ملخص (عربي)')->rows(3),
                    Forms\Components\Textarea::make('excerpt_en')->label('ملخص (إنجليزي)')->rows(3),
                ])->columns(2),

            Forms\Components\Section::make('محتوى المقال')
                ->schema([
                    Forms\Components\RichEditor::make('content_ar')
                        ->label('المحتوى (عربي)')
                        ->fileAttachmentsDirectory('blogs')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('content_en')
                        ->label('المحتوى (إنجليزي)')
                        ->fileAttachmentsDirectory('blogs')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('صورة')->disk('public'),
                Tables\Columns\TextColumn::make('title_ar')->label('العنوان')->searchable()->limit(50),
                Tables\Columns\IconColumn::make('is_published')->label('منشور')->boolean(),
                Tables\Columns\TextColumn::make('published_at')->label('تاريخ النشر')->dateTime()->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('الحالة')
                    ->trueLabel('منشور')->falseLabel('غير منشور'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit'   => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
