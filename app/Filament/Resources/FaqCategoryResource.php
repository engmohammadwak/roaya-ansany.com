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
    protected static ?string $model = FaqCategory::class;
    protected static ?string $navigationIcon  = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'المحتوى';
    protected static ?string $navigationLabel = 'أسئلة شائعة';
    protected static ?int    $navigationSort  = 30;

    /* ------------------------------------------------------------------ */
    /*  FORM – إنشاء / تعديل فئة                                           */
    /* ------------------------------------------------------------------ */
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('🏷️ اسم الفئة')
                ->schema([
                    Forms\Components\TextInput::make('name_ar')
                        ->label('الاسم (عربي)')
                        ->required(),
                    Forms\Components\TextInput::make('name_en')
                        ->label('الاسم (إنجليزي)')
                        ->required(),
                    Forms\Components\TextInput::make('sort_order')
                        ->label('الترتيب')
                        ->numeric()
                        ->default(0),
                ])->columns(2),
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  TABLE                                                               */
    /* ------------------------------------------------------------------ */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_ar')->label('الاسم (عربي)')->searchable(),
                Tables\Columns\TextColumn::make('name_en')->label('الاسم (إنجليزي)')->searchable(),
                Tables\Columns\TextColumn::make('sort_order')->label('الترتيب')->sortable(),
                Tables\Columns\TextColumn::make('faqs_count')->label('عدد الأسئلة')->counts('faqs'),
            ])
            ->defaultSort('sort_order')

            /* ---------- أزرار الرأس ---------- */
            ->headerActions([

                /* زر إضافة سؤال جديد */
                Tables\Actions\Action::make('add_faq')
                    ->label('➕ إضافة سؤال')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->form(self::faqForm())
                    ->action(function (array $data) {
                        Faq::create([
                            'faq_category_id' => $data['faq_category_id'] ?? null,
                            'question_ar'     => $data['question_ar'],
                            'question_en'     => $data['question_en']     ?? null,
                            'answer_ar'       => $data['answer_ar'],
                            'answer_en'       => $data['answer_en']       ?? null,
                            'sort_order'      => $data['sort_order']      ?? 0,
                            'is_active'       => $data['is_active']       ?? true,
                        ]);
                        Notification::make()->title('تمت إضافة السؤال ✅')->success()->send();
                    }),

                /* زر إعدادات صفحة الأسئلة */
                Tables\Actions\Action::make('faq_page_settings')
                    ->label('⚙️ إعدادات الصفحة')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->color('gray')
                    ->form([
                        Forms\Components\Section::make('📋 عنوان صفحة الأسئلة الشائعة')
                            ->schema([
                                Forms\Components\TextInput::make('faq_hero_title_ar')
                                    ->label('العنوان الرئيسي (عربي)')
                                    ->default(fn() => Setting::get('faq_hero_title_ar', 'الأسئلة الشائعة'))
                                    ->required(),
                                Forms\Components\TextInput::make('faq_hero_title_en')
                                    ->label('العنوان الرئيسي (إنجليزي)')
                                    ->default(fn() => Setting::get('faq_hero_title_en', 'Frequently Asked Questions'))
                                    ->required(),
                            ])->columns(2),
                        Forms\Components\Section::make('💬 الوصف / العنوان الفرعي')
                            ->schema([
                                Forms\Components\TextInput::make('faq_hero_subtitle_ar')
                                    ->label('الوصف (عربي)')
                                    ->default(fn() => Setting::get('faq_hero_subtitle_ar', 'إجابات على أكثر الأسئلة شيوعاً')),
                                Forms\Components\TextInput::make('faq_hero_subtitle_en')
                                    ->label('الوصف (إنجليزي)')
                                    ->default(fn() => Setting::get('faq_hero_subtitle_en', 'Answers to the most common questions')),
                            ])->columns(2),
                    ])
                    ->action(function (array $data) {
                        Setting::set('faq_hero_title_ar',    $data['faq_hero_title_ar']);
                        Setting::set('faq_hero_title_en',    $data['faq_hero_title_en']);
                        Setting::set('faq_hero_subtitle_ar', $data['faq_hero_subtitle_ar']);
                        Setting::set('faq_hero_subtitle_en', $data['faq_hero_subtitle_en']);
                        Notification::make()->title('تم الحفظ بنجاح ✅')->success()->send();
                    }),
            ])

            /* ---------- أزرار كل صف ---------- */
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل الفئة'),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    /* ------------------------------------------------------------------ */
    /*  نموذج السؤال (مشترك بين إضافة + تعديل)                            */
    /* ------------------------------------------------------------------ */
    protected static function faqForm(): array
    {
        return [
            Forms\Components\Section::make('📂 التصنيف والحالة')
                ->schema([
                    Forms\Components\Select::make('faq_category_id')
                        ->label('الفئة')
                        ->options(FaqCategory::orderBy('sort_order')->pluck('name_ar', 'id'))
                        ->searchable()
                        ->nullable(),
                    Forms\Components\Toggle::make('is_active')
                        ->label('نشط')
                        ->default(true),
                    Forms\Components\TextInput::make('sort_order')
                        ->label('الترتيب')
                        ->numeric()
                        ->default(0),
                ])->columns(3),

            Forms\Components\Section::make('❓ السؤال')
                ->schema([
                    Forms\Components\Textarea::make('question_ar')
                        ->label('السؤال (عربي)')
                        ->required()
                        ->rows(2),
                    Forms\Components\Textarea::make('question_en')
                        ->label('السؤال (إنجليزي)')
                        ->rows(2),
                ])->columns(2),

            Forms\Components\Section::make('💡 الإجابة')
                ->schema([
                    Forms\Components\RichEditor::make('answer_ar')
                        ->label('الإجابة (عربي)')
                        ->required(),
                    Forms\Components\RichEditor::make('answer_en')
                        ->label('الإجابة (إنجليزي)'),
                ])->columns(2),
        ];
    }

    /* ------------------------------------------------------------------ */
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFaqCategories::route('/'),
            'create' => Pages\CreateFaqCategory::route('/create'),
            'edit'   => Pages\EditFaqCategory::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }
}
