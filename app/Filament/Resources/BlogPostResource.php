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
    protected static ?string $navigationLabel = 'المدونة (قديم)';
    protected static ?string $navigationGroup = 'إدارة الصفحات';
    protected static ?int $navigationSort = 99;

    // مخفي من الناف بار — يُفتح فقط عبر الرابط المباشر
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('معلومات المنشور')
                ->schema([
                    Forms\Components\TextInput::make('title_ar')
                        ->label('الموضوع (عربي)')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) =>
                            $set('slug', Str::slug($state))
                        ),
                    Forms\Components\TextInput::make('title_en')
                        ->label('الموضوع (إنجليزي)'),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug (رابط المقال)')
                        ->required()
                        ->unique(ignorable: fn ($record) => $record)
                        ->helperText('يتولد تلقائياً — يمكنك تعديله'),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('تاريخ النشر')
                        ->default(now()),
                    Forms\Components\Toggle::make('is_published')
                        ->label('ظاهر في الموقع')
                        ->default(true)
                        ->onColor('success')
                        ->offColor('danger'),
                    Forms\Components\FileUpload::make('image')
                        ->label('الصورة الرئيسية')
                        ->image()
                        ->directory('blog')
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('الملخص')
                ->schema([
                    Forms\Components\Textarea::make('excerpt_ar')->label('ملخص (عربي)')->rows(3),
                    Forms\Components\Textarea::make('excerpt_en')->label('ملخص (إنجليزي)')->rows(3),
                ])->columns(2),

            Forms\Components\Section::make('المحتوى')
                ->schema([
                    Forms\Components\RichEditor::make('body_ar')
                        ->label('المحتوى (عربي)')
                        ->fileAttachmentsDirectory('blog')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('body_en')
                        ->label('المحتوى (إنجليزي)')
                        ->fileAttachmentsDirectory('blog')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة')
                    ->disk('public')
                    ->width(60)->height(50),

                Tables\Columns\TextColumn::make('title_ar')
                    ->label('الموضوع')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->color('gray')
                    ->limit(40),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('ظاهر في الموقع')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('تاريخ النشر')
                    ->dateTime('Y-m-d')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('حالة النشر')
                    ->trueLabel('ظاهر')->falseLabel('مخفي'),
            ])
            ->actions([
                // عرض في الموقع
                Tables\Actions\Action::make('preview')
                    ->label('عرض')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->url(fn (BlogPost $record) => url('ar/blogs/'.$record->slug))
                    ->openUrlInNewTab(),

                // تعديل
                Tables\Actions\EditAction::make()
                    ->label('تعديل'),

                // إخفاء / إظهار من الموقع
                Tables\Actions\Action::make('toggle_publish')
                    ->label(fn (BlogPost $record) => $record->is_published ? 'إخفاء' : 'إظهار')
                    ->icon(fn (BlogPost $record) => $record->is_published
                        ? 'heroicon-o-eye-slash'
                        : 'heroicon-o-eye'
                    )
                    ->color(fn (BlogPost $record) => $record->is_published ? 'warning' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn (BlogPost $record) => $record->is_published
                        ? 'إخفاء المنشور من الموقع؟'
                        : 'إظهار المنشور في الموقع؟'
                    )
                    ->modalDescription(fn (BlogPost $record) => $record->is_published
                        ? 'سيختفي هذا المنشور من الموقع فوراً.'
                        : 'سيظهر هذا المنشور في الموقع فوراً.'
                    )
                    ->action(fn (BlogPost $record) =>
                        $record->update(['is_published' => !$record->is_published])
                    ),

                // حذف
                Tables\Actions\DeleteAction::make()
                    ->label('حذف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit'   => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
