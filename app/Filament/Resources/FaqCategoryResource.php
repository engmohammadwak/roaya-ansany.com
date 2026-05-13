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
    protected static ?string $model = Faq::class;
    protected static ?string $navigationIcon  = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'المحتوى';
    protected static ?string $navigationLabel = 'الأسئلة الشائعة';
    protected static ?string $slug            = 'faq-categories';
    protected static ?int    $navigationSort  = 30;

    public static function form(Form $form): Form
    {
        return $form->schema(self::faqFormSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')   // ← drag & drop
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('question_ar')
                    ->label('السؤال (عربي)')
                    ->searchable()
                    ->limit(60),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('ظاهر'),
            ])
            ->headerActions([

                // ➕ إضافة سؤال
                Tables\Actions\Action::make('add_faq')
                    ->label('➕ إضافة سؤال')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->form(self::faqFormSchema())
                    ->action(function (array $data) {
                        // الترتيب التلقائي = آخر رقم + 1
                        $nextOrder = (Faq::max('sort_order') ?? 0) + 1;
                        Faq::create([
                            'question_ar' => $data['question_ar'],
                            'question_en' => $data['question_en'] ?? null,
                            'answer_ar'   => $data['answer_ar'],
                            'answer_en'   => $data['answer_en']   ?? null,
                            'sort_order'  => $nextOrder,
                            'is_active'   => (bool)($data['is_active'] ?? true),
                        ]);
                        Notification::make()->title('تمت إضافة السؤال ✅')->success()->send();
                    }),

                // ⚙️ إعدادات الصفحة
                Tables\Actions\Action::make('faq_page_settings')
                    ->label('⚙️ إعدادات الصفحة')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->color('gray')
                    ->fillForm(fn() => [
                        'home_faq_label_ar' => Setting::get('home_faq_label_ar', ''),
                        'home_faq_label_en' => Setting::get('home_faq_label_en', ''),
                        'home_faq_title_ar' => Setting::get('home_faq_title_ar', ''),
                        'home_faq_title_en' => Setting::get('home_faq_title_en', ''),
                    ])
                    ->form([
                        Forms\Components\Section::make('📌 عناوين قسم الأسئلة في الصفحة الرئيسية')
                            ->schema([
                                Forms\Components\TextInput::make('home_faq_label_ar')->label('العنوان الصغير (عربي)'),
                                Forms\Components\TextInput::make('home_faq_label_en')->label('العنوان الصغير (إنجليزي)'),
                                Forms\Components\TextInput::make('home_faq_title_ar')->label('العنوان الكبير (عربي)'),
                                Forms\Components\TextInput::make('home_faq_title_en')->label('العنوان الكبير (إنجليزي)'),
                            ])->columns(2),
                    ])
                    ->action(function (array $data) {
                        Setting::set('home_faq_label_ar', $data['home_faq_label_ar']);
                        Setting::set('home_faq_label_en', $data['home_faq_label_en']);
                        Setting::set('home_faq_title_ar', $data['home_faq_title_ar']);
                        Setting::set('home_faq_title_en', $data['home_faq_title_en']);
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

    // فورم السؤال — بدون فئة وبدون ترتيب
    protected static function faqFormSchema(): array
    {
        return [
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
            Forms\Components\Toggle::make('is_active')
                ->label('ظاهر في الموقع')
                ->default(true),
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
