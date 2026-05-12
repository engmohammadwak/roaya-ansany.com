<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'المقالات';
    protected static ?string $modelLabel = 'مقالة';
    protected static ?string $pluralModelLabel = 'المقالات';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('translations')->tabs([
                Forms\Components\Tabs\Tab::make('العربية')->schema([
                    Forms\Components\TextInput::make('title_ar')
                        ->label('العنوان بالعربية')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                            $set('slug', Str::slug($state))
                        ),
                    Forms\Components\Textarea::make('excerpt_ar')
                        ->label('المقتطف بالعربية')
                        ->rows(3),
                    Forms\Components\RichEditor::make('content_ar')
                        ->label('المحتوى بالعربية')
                        ->required(),
                ]),
                Forms\Components\Tabs\Tab::make('English')->schema([
                    Forms\Components\TextInput::make('title_en')
                        ->label('Title in English')
                        ->required(),
                    Forms\Components\Textarea::make('excerpt_en')
                        ->label('Excerpt in English')
                        ->rows(3),
                    Forms\Components\RichEditor::make('content_en')
                        ->label('Content in English')
                        ->required(),
                ]),
            ])->columnSpanFull(),

            Forms\Components\TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->unique(Blog::class, 'slug', ignoreRecord: true),

            Forms\Components\FileUpload::make('image')
                ->label('الصورة')
                ->image()
                ->directory('blogs'),

            Forms\Components\Toggle::make('is_published')
                ->label('منشور')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('الصورة'),
                Tables\Columns\TextColumn::make('title_ar')->label('العنوان')->searchable(),
                Tables\Columns\IconColumn::make('is_published')->label('منشور')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإنشاء')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('الحالة'),
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
