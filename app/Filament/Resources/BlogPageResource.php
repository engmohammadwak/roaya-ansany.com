<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BlogPageResource\Pages;
use App\Models\BlogPage;
use App\Models\Campaign;
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

            Forms\Components\Section::make('حالة المدونة')
                ->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('إظهار المدونة في الموقع')
                        ->helperText('عند الإيقاف تختفي المدونة من القائمة والفوتر ويعود الرابط بـ 404')
                        ->default(true)
                        ->onColor('success')
                        ->offColor('danger')
                        ->columnSpanFull(),
                ])->columns(1),

            Forms\Components\Section::make('صورة الهيرو')
                ->schema([
                    Forms\Components\FileUpload::make('hero_image')
                        ->label('صورة الهيرو (تظهر على اليسار)')
                        ->image()
                        ->directory('blog-page')
                        ->helperText('لو تركتها فارغة يستخدم الصورة الافتراضية')
                        ->columnSpanFull(),
                ])->columns(1),

            Forms\Components\Section::make('بطاقة التبرع')
                ->description('النصوص التي تظهر على اليمين في قسم الهيرو')
                ->schema([
                    Forms\Components\TextInput::make('hero_cats_ar')
                        ->label('تيجات البطاقة (عربي) — فصل بفاصلة')
                        ->helperText('مثال: حكاية,حياة,كرم'),
                    Forms\Components\TextInput::make('hero_cats_en')
                        ->label('تيجات البطاقة (إنجليزي)')
                        ->helperText('Example: Story,Life,Generosity'),
                    Forms\Components\TextInput::make('hero_sub_ar')->label('العنوان الرئيسي (عربي)'),
                    Forms\Components\TextInput::make('hero_sub_en')->label('العنوان الرئيسي (إنجليزي)'),
                    Forms\Components\Textarea::make('hero_para_ar')->label('النص (عربي)')->rows(3),
                    Forms\Components\Textarea::make('hero_para_en')->label('النص (إنجليزي)')->rows(3),
                ])->columns(2),

            Forms\Components\Section::make('شريط التقدم (الأخضر)')
                ->description('اختر حملة لتحديد نسبة التقدم والمبلغ الضايل')
                ->schema([
                    Forms\Components\Select::make('campaign_id')
                        ->label('الحملة المرتبطة')
                        ->options(Campaign::active()->pluck('title_ar','id'))
                        ->searchable()
                        ->nullable()
                        ->helperText('شريط التقدم يعكس نسبة تحصيل هذه الحملة')
                        ->columnSpanFull(),
                ])->columns(1),

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
                Tables\Columns\IconColumn::make('is_active')->label('المدونة نشطة')->boolean(),
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
