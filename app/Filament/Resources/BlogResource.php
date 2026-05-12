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
    protected static ?string $model          = Blog::class;
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
            Forms\Components\Tabs::make('blog_tabs')
                ->tabs([

                    // ========== TAB 1: معلومات أساسية ==========
                    Forms\Components\Tabs\Tab::make('المعلومات الأساسية')
                        ->icon('heroicon-o-document-text')
                        ->schema([

                            Forms\Components\Section::make('العناوين')
                                ->schema([
                                    Forms\Components\TextInput::make('title_ar')
                                        ->label('العنوان (عربي)')
                                        ->required()
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function (Set $set, ?string $state, ?string $old) {
                                            if (!$old || $old === '') {
                                                $slug = Str::slug($state);
                                                if (empty($slug)) $slug = 'blog-'.time();
                                                $set('slug', $slug);
                                            }
                                            // Auto-fill SEO fields if empty
                                            $set('meta_title_ar', $state);
                                        })
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('title_en')
                                        ->label('العنوان (إنجليزي)')
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, ?string $state) =>
                                            $set('meta_title_en', $state)
                                        )
                                        ->maxLength(255),
                                ])->columns(2),

                            Forms\Components\Section::make('السلوج والنشر')
                                ->schema([
                                    Forms\Components\TextInput::make('slug')
                                        ->label('Slug — رابط المقال')
                                        ->required()
                                        ->unique(Blog::class, 'slug', ignoreRecord: true)
                                        ->helperText('يُولد تلقائياً من العنوان — يمكنك تعديله يدوياً'
                                        )
                                        ->prefix(url('ar/blogs').'/'),

                                    Forms\Components\DateTimePicker::make('published_at')
                                        ->label('تاريخ النشر')
                                        ->default(now())
                                        ->required(),

                                    Forms\Components\Toggle::make('is_published')
                                        ->label('منشور')
                                        ->default(true)
                                        ->onColor('success')
                                        ->helperText('أوقف التبديل لحفظه كمسودة'),
                                ])->columns(3),

                            Forms\Components\Section::make('الصورة الرئيسية')
                                ->schema([
                                    Forms\Components\FileUpload::make('image')
                                        ->label('صورة المقال')
                                        ->image()
                                        ->directory('news')
                                        ->imagePreviewHeight('200')
                                        ->columnSpanFull(),
                                ]),

                            Forms\Components\Section::make('الملخص')
                                ->schema([
                                    Forms\Components\Textarea::make('excerpt_ar')
                                        ->label('ملخص (عربي)')
                                        ->rows(3)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, ?string $state) =>
                                            $set('meta_desc_ar', Str::limit($state, 160))
                                        )
                                        ->helperText('يظهر في بطاقة المقال وتحت العنوان'),
                                    Forms\Components\Textarea::make('excerpt_en')
                                        ->label('ملخص (إنجليزي)')
                                        ->rows(3)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Set $set, ?string $state) =>
                                            $set('meta_desc_en', Str::limit($state, 160))
                                        ),
                                ])->columns(2),

                        ]),

                    // ========== TAB 2: المحتوى ==========
                    Forms\Components\Tabs\Tab::make('المحتوى')
                        ->icon('heroicon-o-pencil-square')
                        ->schema([
                            Forms\Components\RichEditor::make('body_ar')
                                ->label('المحتوى (عربي)')
                                ->fileAttachmentsDirectory('blogs')
                                ->toolbarButtons([
                                    'bold','italic','underline','strike',
                                    'link','bulletList','orderedList',
                                    'h2','h3','blockquote',
                                    'attachFiles','undo','redo',
                                ])
                                ->columnSpanFull(),
                            Forms\Components\RichEditor::make('body_en')
                                ->label('المحتوى (إنجليزي)')
                                ->fileAttachmentsDirectory('blogs')
                                ->toolbarButtons([
                                    'bold','italic','underline','strike',
                                    'link','bulletList','orderedList',
                                    'h2','h3','blockquote',
                                    'attachFiles','undo','redo',
                                ])
                                ->columnSpanFull(),
                        ]),

                    // ========== TAB 3: SEO ==========
                    Forms\Components\Tabs\Tab::make('SEO')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([

                            Forms\Components\Section::make('عناوين محركات البحث')
                                ->description('يظهر في نتائج جوجل — مثالي: 50–60 حرف')
                                ->schema([
                                    Forms\Components\TextInput::make('meta_title_ar')
                                        ->label('Meta Title (عربي)')
                                        ->maxLength(60)
                                        ->helperText(
                                            fn ($state) => strlen($state ?? '') . ' / 60 حرف'
                                        )
                                        ->suffix(fn ($state) => strlen($state ?? '') > 60 ? '❌ طويل' : '✅'),
                                    Forms\Components\TextInput::make('meta_title_en')
                                        ->label('Meta Title (English)')
                                        ->maxLength(60)
                                        ->suffix(fn ($state) => strlen($state ?? '') > 60 ? '❌ Long' : '✅'),
                                ])->columns(2),

                            Forms\Components\Section::make('وصف محركات البحث')
                                ->description('يظهر تحت العنوان في جوجل — مثالي: 150–160 حرف')
                                ->schema([
                                    Forms\Components\Textarea::make('meta_desc_ar')
                                        ->label('Meta Description (عربي)')
                                        ->rows(3)
                                        ->maxLength(160)
                                        ->helperText(
                                            fn ($state) => strlen($state ?? '') . ' / 160 حرف'
                                        ),
                                    Forms\Components\Textarea::make('meta_desc_en')
                                        ->label('Meta Description (English)')
                                        ->rows(3)
                                        ->maxLength(160)
                                        ->helperText(
                                            fn ($state) => strlen($state ?? '') . ' / 160 chars'
                                        ),
                                ])->columns(2),

                            Forms\Components\Section::make('Open Graph / سوشيال ميديا')
                                ->description('الصورة والبيانات التي تظهر عند مشاركة الرابط في فيسبوك / تويتر / واتسآب')
                                ->schema([
                                    Forms\Components\FileUpload::make('og_image')
                                        ->label('صورة OG (1200x630)')
                                        ->image()
                                        ->directory('blogs/og')
                                        ->helperText('لو تركتها فارغة يستخدم صورة المقال')
                                        ->columnSpanFull(),
                                ]),

                            Forms\Components\Section::make('إعدادات متقدمة')
                                ->schema([
                                    Forms\Components\TextInput::make('focus_keyword')
                                        ->label('الكلمة المفتاحية الرئيسية')
                                        ->helperText('مثال: تبرع غزة — استخدمها في العنوان والمحتوى'),
                                    Forms\Components\TextInput::make('canonical_url')
                                        ->label('Canonical URL')
                                        ->url()
                                        ->helperText('اتركه فارغاً ليتولد تلقائياً'),
                                    Forms\Components\Select::make('robots')
                                        ->label('Robots')
                                        ->options([
                                            'index, follow'     => '✅ index, follow (افتراضي)',
                                            'noindex, follow'   => '❌ noindex (أخفي من جوجل)',
                                            'index, nofollow'   => 'index, nofollow',
                                            'noindex, nofollow' => '❌❌ خفي كلياً',
                                        ])
                                        ->default('index, follow'),
                                    Forms\Components\Select::make('schema_type')
                                        ->label('Schema Type')
                                        ->options([
                                            'Article'     => 'Article',
                                            'NewsArticle' => 'NewsArticle',
                                            'BlogPosting' => 'BlogPosting',
                                        ])
                                        ->default('BlogPosting'),
                                ])->columns(2),

                        ]),

                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('صورة')
                    ->disk('public')
                    ->width(60)->height(50),
                Tables\Columns\TextColumn::make('title_ar')
                    ->label('العنوان')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->color('gray')
                    ->limit(40),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('منشور')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('تاريخ النشر')
                    ->dateTime('Y-m-d')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('حالة النشر')
                    ->trueLabel('منشور')
                    ->falseLabel('مسودة'),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('عرض')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Blog $record) => url('ar/blogs/'.$record->slug))
                    ->openUrlInNewTab(),
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
