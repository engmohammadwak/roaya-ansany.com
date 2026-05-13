<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeSettingResource\Pages;
use App\Models\HomeSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomeSettingResource extends Resource
{
    protected static ?string $model = HomeSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'الصفحة الرئيسية';
    protected static ?string $navigationGroup = 'إعدادات الموقع';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Tabs::make('الإعدادات')
                ->tabs([

                    // ======= HERO =======
                    Forms\Components\Tabs\Tab::make('🦸 Hero Banner')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('hero_title_ar')
                                    ->label('العنوان الرئيسي (عربي)')->required(),
                                Forms\Components\TextInput::make('hero_title_en')
                                    ->label('Main Title (English)'),
                                Forms\Components\Textarea::make('hero_description_ar')
                                    ->label('الوصف (عربي)')->rows(3),
                                Forms\Components\Textarea::make('hero_description_en')
                                    ->label('Description (English)')->rows(3),
                                Forms\Components\TextInput::make('hero_label_ar')
                                    ->label('النص فوق الصورة (عربي)'),
                                Forms\Components\TextInput::make('hero_label_en')
                                    ->label('Image Label (English)'),
                            ]),
                            Forms\Components\FileUpload::make('hero_image')
                                ->label('صورة الـ Hero')
                                ->image()->directory('home/hero')
                                ->columnSpanFull(),
                        ]),

                    // ======= CAMPAIGN BANNER =======
                    Forms\Components\Tabs\Tab::make('📜 Campaign Banner')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('cb_title_ar')
                                    ->label('العنوان (عربي)'),
                                Forms\Components\TextInput::make('cb_title_en')
                                    ->label('Title (English)'),
                                Forms\Components\TextInput::make('cb_subtitle_ar')
                                    ->label('العنوان الفرعي (عربي)'),
                                Forms\Components\TextInput::make('cb_subtitle_en')
                                    ->label('Subtitle (English)'),
                                Forms\Components\Textarea::make('cb_description_ar')
                                    ->label('النص الكامل (عربي)')->rows(6)->columnSpan(2),
                                Forms\Components\Textarea::make('cb_description_en')
                                    ->label('Full Text (English)')->rows(6)->columnSpan(2),
                            ]),
                            Forms\Components\FileUpload::make('cb_image')
                                ->label('صورة البانر')
                                ->image()->directory('home/campaign-banner')
                                ->columnSpanFull(),
                        ]),

                    // ======= WHY DONATE =======
                    Forms\Components\Tabs\Tab::make('🎯 لماذا تتبرع؟')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('why_donate_label_ar')
                                    ->label('النص الصغير فوق العنوان (عربي)')
                                    ->placeholder('لماذا تتبرع لنا؟'),
                                Forms\Components\TextInput::make('why_donate_label_en')
                                    ->label('Small Label (English)')
                                    ->placeholder('Why donate to us?'),
                                Forms\Components\TextInput::make('why_donate_title_ar')
                                    ->label('العنوان الكبير (عربي)')
                                    ->placeholder('لأننا نهتم بالحالات الأكثر احتياجًا.'),
                                Forms\Components\TextInput::make('why_donate_title_en')
                                    ->label('Main Title (English)')
                                    ->placeholder('Because we care about those in greatest need.'),
                            ]),
                            Forms\Components\Repeater::make('why_cards')
                                ->label('كروت لماذا تتبرع')
                                ->schema([
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('العنوان (عربي)')->required(),
                                        Forms\Components\TextInput::make('title_en')
                                            ->label('Title (English)'),
                                        Forms\Components\Textarea::make('description')
                                            ->label('الوصف (عربي)')->rows(2),
                                        Forms\Components\Textarea::make('description_en')
                                            ->label('Description (English)')->rows(2),
                                    ]),
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\FileUpload::make('icon')
                                            ->label('صورة الأيقونة')
                                            ->image()
                                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml'])
                                            ->directory('home/why-icons')
                                            ->imagePreviewHeight('80')
                                            ->helperText('ارفع PNG أو SVG — اللون أدناه يطبّق على SVG فقط'),
                                        Forms\Components\ColorPicker::make('icon_color')
                                            ->label('لون الأيقونة (SVG فقط)')
                                            ->helperText('يغيّر لون صورة SVG عبر CSS filter'),
                                    ]),
                                    Forms\Components\ColorPicker::make('color')
                                        ->label('لون خلفية الكارت')
                                        ->columnSpanFull(),
                                ])
                                ->addActionLabel('+ إضافة كارت')
                                ->collapsible()
                                ->reorderable()
                                ->columnSpanFull(),
                        ]),

                    // ======= FAQ =======
                    Forms\Components\Tabs\Tab::make('❓ الأسئلة الشائعة')
                        ->schema([
                            Forms\Components\Repeater::make('faqs')
                                ->label('أسئلة وأجوبة')
                                ->schema([
                                    Forms\Components\TextInput::make('question')
                                        ->label('السؤال (عربي)')->required(),
                                    Forms\Components\TextInput::make('question_en')
                                        ->label('Question (English)'),
                                    Forms\Components\Textarea::make('answer')
                                        ->label('الجواب (عربي)')->rows(3),
                                    Forms\Components\Textarea::make('answer_en')
                                        ->label('Answer (English)')->rows(3),
                                ])
                                ->addActionLabel('+ إضافة سؤال')
                                ->collapsible()
                                ->reorderable()
                                ->columnSpanFull(),
                        ]),

                    // ======= ABOUT =======
                    Forms\Components\Tabs\Tab::make('🏛️ عن المؤسسة')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('about_title_ar')
                                    ->label('العنوان (عربي)'),
                                Forms\Components\TextInput::make('about_title_en')
                                    ->label('Title (English)'),
                                Forms\Components\Textarea::make('about_description_ar')
                                    ->label('الوصف (عربي)')->rows(4),
                                Forms\Components\Textarea::make('about_description_en')
                                    ->label('Description (English)')->rows(4),
                            ]),
                            Forms\Components\FileUpload::make('about_image')
                                ->label('الصورة')->image()->directory('home/about')
                                ->columnSpanFull(),
                        ]),

                    // ======= STATS =======
                    Forms\Components\Tabs\Tab::make('📊 Stats')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('stats_title_ar')
                                    ->label('عنوان الإحصاءات (عربي)'),
                                Forms\Components\TextInput::make('stats_title_en')
                                    ->label('Stats Title (English)'),
                            ]),
                            Forms\Components\FileUpload::make('stats_image')
                                ->label('صورة الخلفية')->image()->directory('home/stats')
                                ->columnSpanFull(),
                        ]),

                    // ======= SUPPORT =======
                    Forms\Components\Tabs\Tab::make('🤝 قسم الدعم')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('support_title_ar')
                                    ->label('العنوان (عربي)')
                                    ->placeholder('من نحن'),
                                Forms\Components\TextInput::make('support_title_en')
                                    ->label('Title (English)')
                                    ->placeholder('About Us'),
                                Forms\Components\Textarea::make('support_description_ar')
                                    ->label('الوصف (عربي)')->rows(3)
                                    ->placeholder('مؤسسة خيرية غير ربحية.'),
                                Forms\Components\Textarea::make('support_description_en')
                                    ->label('Description (English)')->rows(3)
                                    ->placeholder('A non-profit charitable organization.'),
                            ]),
                            Forms\Components\FileUpload::make('support_image')
                                ->label('الصورة')->image()->directory('home/support')
                                ->columnSpanFull(),
                            Forms\Components\Repeater::make('support_items')
                                ->label('عناصر القائمة')
                                ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->label('العنصر (عربي)')->required(),
                                    Forms\Components\TextInput::make('title_en')
                                        ->label('Item (English)'),
                                ])
                                ->addActionLabel('+ إضافة عنصر')
                                ->reorderable()
                                ->columnSpanFull(),
                        ]),

                    // ======= NEWSLETTER =======
                    Forms\Components\Tabs\Tab::make('📧 Newsletter')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('newsletter_title_ar')
                                    ->label('العنوان (عربي)'),
                                Forms\Components\TextInput::make('newsletter_title_en')
                                    ->label('Title (English)'),
                                Forms\Components\Textarea::make('newsletter_description_ar')
                                    ->label('الوصف (عربي)'),
                                Forms\Components\Textarea::make('newsletter_description_en')
                                    ->label('Description (English)'),
                            ]),
                        ]),

                    // ======= DONATION COUNTER =======
                    Forms\Components\Tabs\Tab::make('💰 عداد التبرع')
                        ->schema([
                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\TextInput::make('donation_goal')
                                    ->label('الهدف الكلي')->numeric()
                                    ->prefix('$')->helperText('المبلغ الكلي المطلوب'),
                                Forms\Components\TextInput::make('donation_raised')
                                    ->label('المبلغ المجموع حتى الآن')->numeric()
                                    ->prefix('$')->helperText('كلما زاد هذا الرقم يتحرك العداد'),
                                Forms\Components\TextInput::make('donation_currency')
                                    ->label('العملة')->default('$'),
                            ]),
                        ]),

                ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#'),
                Tables\Columns\TextColumn::make('hero_title_ar')->label('عنوان الهيرو'),
                Tables\Columns\TextColumn::make('donation_raised')->label('المبلغ المجموع')->money('USD'),
                Tables\Columns\TextColumn::make('updated_at')->label('آخر تعديل')->since(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomeSettings::route('/'),
            'edit'  => Pages\EditHomeSetting::route('/{record}/edit'),
        ];
    }
}
