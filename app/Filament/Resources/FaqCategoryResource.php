<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqCategoryResource\Pages;
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_ar')->label('الاسم (عربي)')->searchable(),
                Tables\Columns\TextColumn::make('name_en')->label('الاسم (إنجليزي)')->searchable(),
                Tables\Columns\TextColumn::make('sort_order')->label('الترتيب')->sortable(),
                Tables\Columns\TextColumn::make('faqs_count')->label('عدد الأسئلة')->counts('faqs'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('faq_page_settings')
                    ->label('⚙️ إعدادات صفحة الأسئلة')
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
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

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
