<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqCategoryResource\Pages;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class FaqCategoryResource extends Resource
{
    protected static ?string $model = Faq::class;  // الجدول الرئيسي = الأسئلة
    protected static ?string $navigationIcon  = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'المحتوى';
    protected static ?string $navigationLabel = 'الأسئلة الشائعة';
    protected static ?string $slug            = 'faq-categories';
    protected static ?int    $navigationSort  = 30;

    // ── form لتعديل سؤال موجود ──────────────────────────────
    public static function form(Form $form): Form
    {
        return $form->schema(self::faqFormSchema());
    }

    // ── الجدول الرئيسي: يعرض الأسئلة ────────────────────────
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question_ar')
                    ->label('السؤال (عربي)')
                    ->searchable()
                    ->limit(60),
                Tables\Columns\TextColumn::make('category.name_ar')
                    ->label('الفئة')
                    ->placeholder('— بدون فئة —')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('ظاهر'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('faq_category_id')
                    ->label('تصفية حسب الفئة')
                    ->options(FaqCategory::orderBy('sort_order')->pluck('name_ar', 'id'))
                    ->placeholder('كل الفئات'),
            ])
            ->headerActions([

                // ➕ إضافة سؤال
                Tables\Actions\Action::make('add_faq')
                    ->label('➕ إضافة سؤال')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->form(self::faqFormSchema())
                    ->action(function (array $data) {
                        Faq::create([
                            'faq_category_id' => $data['faq_category_id'] ?: null,
                            'question_ar'     => $data['question_ar'],
                            'question_en'     => $data['question_en']  ?? null,
                            'answer_ar'       => $data['answer_ar'],
                            'answer_en'       => $data['answer_en']    ?? null,
                            'sort_order'      => (int)($data['sort_order'] ?? 0),
                            'is_active'       => (bool)($data['is_active'] ?? true),
                        ]);
                        Notification::make()->title('تمت إضافة السؤال ✅')->success()->send();
                    }),

                // ⚙️ إعدادات الصفحة
                Tables\Actions\Action::make('faq_page_settings')
                    ->label('⚙️ إعدادات الصفحة')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->color('gray')
                    ->form([
                        Forms\Components\Section::make('📌 عناوين قسم الأسئلة في الصفحة الرئيسية')
                            ->schema([
                                Forms\Components\TextInput::make('home_faq_label_ar')
                                    ->label('العنوان الصغير (عربي)')
                                    ->default(fn() => Setting::get('home_faq_label_ar', 'الأسئلة الشائعة')),
                                Forms\Components\TextInput::make('home_faq_label_en')
                                    ->label('العنوان الصغير (إنجليزي)')
                                    ->default(fn() => Setting::get('home_faq_label_en', 'FAQ')),
                                Forms\Components\TextInput::make('home_faq_title_ar')
                                    ->label('العنوان الكبير (عربي)')
                                    ->default(fn() => Setting::get('home_faq_title_ar', 'أسئلة وأجوبة')),
                                Forms\Components\TextInput::make('home_faq_title_en')
                                    ->label('العنوان الكبير (إنجليزي)')
                                    ->default(fn() => Setting::get('home_faq_title_en', 'Q&A')),
                            ])->columns(2),

                        Forms\Components\Section::make('📌 عناوين صفحة /faq المستقلة')
                            ->schema([
                                Forms\Components\TextInput::make('faq_hero_title_ar')
                                    ->label('العنوان الرئيسي (عربي)')
                                    ->default(fn() => Setting::get('faq_hero_title_ar', 'الأسئلة الشائعة')),
                                Forms\Components\TextInput::make('faq_hero_title_en')
                                    ->label('العنوان الرئيسي (إنجليزي)')
                                    ->default(fn() => Setting::get('faq_hero_title_en', 'Frequently Asked Questions')),
                                Forms\Components\TextInput::make('faq_hero_subtitle_ar')
                                    ->label('الوصف (عربي)')
                                    ->default(fn() => Setting::get('faq_hero_subtitle_ar', 'إجابات على أكثر الأسئلة شيوعاً')),
                                Forms\Components\TextInput::make('faq_hero_subtitle_en')
                                    ->label('الوصف (إنجليزي)')
                                    ->default(fn() => Setting::get('faq_hero_subtitle_en', 'Answers to the most common questions')),
                            ])->columns(2),

                        // إدارة الفئات
                        Forms\Components\Section::make('🗂️ إدارة الفئات')
                            ->description('أضف أو عدّل فئات الأسئلة الشائعة')
                            ->schema([
                                Forms\Components\Repeater::make('categories')
                                    ->label('')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_ar')->label('الاسم (عربي)')->required(),
                                        Forms\Components\TextInput::make('name_en')->label('الاسم (إنجليزي)'),
                                        Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
                                    ])
                                    ->columns(3)
                                    ->defaultItems(0)
                                    ->default(fn() => FaqCategory::orderBy('sort_order')->get()
                                        ->map(fn($c) => ['name_ar'=>$c->name_ar,'name_en'=>$c->name_en,'sort_order'=>$c->sort_order])
                                        ->toArray()
                                    )
                                    ->addActionLabel('➕ إضافة فئة'),
                            ]),
                    ])
                    ->action(function (array $data) {
                        // حفظ الإعدادات
                        Setting::set('home_faq_label_ar',    $data['home_faq_label_ar']);
                        Setting::set('home_faq_label_en',    $data['home_faq_label_en']);
                        Setting::set('home_faq_title_ar',    $data['home_faq_title_ar']);
                        Setting::set('home_faq_title_en',    $data['home_faq_title_en']);
                        Setting::set('faq_hero_title_ar',    $data['faq_hero_title_ar']);
                        Setting::set('faq_hero_title_en',    $data['faq_hero_title_en']);
                        Setting::set('faq_hero_subtitle_ar', $data['faq_hero_subtitle_ar']);
                        Setting::set('faq_hero_subtitle_en', $data['faq_hero_subtitle_en']);

                        // حفظ الفئات — حذف القديمة وإعادة الإدراج
                        FaqCategory::truncate();
                        foreach ($data['categories'] ?? [] as $cat) {
                            if (!empty($cat['name_ar'])) {
                                FaqCategory::create([
                                    'name_ar'    => $cat['name_ar'],
                                    'name_en'    => $cat['name_en'] ?? null,
                                    'sort_order' => (int)($cat['sort_order'] ?? 0),
                                ]);
                            }
                        }

                        Notification::make()->title('تم الحفظ بنجاح ✅')->success()->send();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // ── schema مشترك للإضافة والتعديل ────────────────────────
    protected static function faqFormSchema(): array
    {
        return [
            Forms\Components\Section::make('📂 التصنيف والحالة')
                ->schema([
                    Forms\Components\Select::make('faq_category_id')
                        ->label('الفئة (اختياري)')
                        ->options(FaqCategory::orderBy('sort_order')->pluck('name_ar', 'id'))
                        ->searchable()
                        ->nullable()
                        ->placeholder('— بدون فئة —'),
                    Forms\Components\Toggle::make('is_active')
                        ->label('ظاهر في الموقع')
                        ->default(true),
                    Forms\Components\TextInput::make('sort_order')
                        ->label('الترتيب')
                        ->numeric()
                        ->default(0),
                ])->columns(3),
            Forms\Components\Section::make('❓ السؤال')
                ->schema([
                    Forms\Components\Textarea::make('question_ar')->label('السؤال (عربي)')->required()->rows(2),
                    Forms\Components\Textarea::make('question_en')->label('السؤال (إنجليزي)')->rows(2),
                ])->columns(2),
            Forms\Components\Section::make('💡 الإجابة')
                ->schema([
                    Forms\Components\RichEditor::make('answer_ar')->label('الإجابة (عربي)')->required(),
                    Forms\Components\RichEditor::make('answer_en')->label('الإجابة (إنجليزي)'),
                ])->columns(2),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFaqCategories::route('/'),
            'create' => Pages\CreateFaqCategory::route('/create'),
            'edit'   => Pages\EditFaqCategory::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array { return []; }
}
