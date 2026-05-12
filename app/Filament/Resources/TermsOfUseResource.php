<?php
namespace App\Filament\Resources;

use App\Filament\Resources\TermsOfUseResource\Pages;
use App\Models\TermsOfUse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TermsOfUseResource extends Resource
{
    protected static ?string $model           = TermsOfUse::class;
    protected static ?string $navigationIcon  = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'شروط الاستخدام';
    protected static ?string $navigationGroup = 'إدارة الصفحات';
    protected static ?int    $navigationSort  = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([

            // ===== بيانات البانر =====
            Forms\Components\Section::make('بيانات البانر العلوي')
                ->description('هذه البيانات تظهر في أعلى صفحة شروط الاستخدام')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('banner_title_ar')
                            ->label('عنوان البانر (عربي)')
                            ->placeholder('شروطنا وأحكامنا…'),
                        Forms\Components\TextInput::make('banner_title_en')
                            ->label('عنوان البانر (إنجليزي)')
                            ->placeholder('Our Terms & Conditions...'),
                    ]),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Textarea::make('banner_desc_ar')
                            ->label('وصف البانر (عربي)')
                            ->rows(3),
                        Forms\Components\Textarea::make('banner_desc_en')
                            ->label('وصف البانر (إنجليزي)')
                            ->rows(3),
                    ]),
                    Forms\Components\DateTimePicker::make('last_updated')
                        ->label('تاريخ آخر تحديث'),
                ]),

            // ===== البنود =====
            Forms\Components\Section::make('بنود الشروط والأحكام')
                ->description('أضف أو عدّل أو احذف البنود. تظهر بالترتيب نفسه في الصفحة.')
                ->schema([
                    Forms\Components\Repeater::make('sections')
                        ->relationship('sections')
                        ->label('')
                        ->orderColumn('sort_order')
                        ->reorderable()
                        ->addActionLabel('➕ أضف بنداً جديداً')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('title_ar')
                                    ->label('عنوان البند (عربي)')
                                    ->required()
                                    ->placeholder('مثال: 1. مقدمة'),
                                Forms\Components\TextInput::make('title_en')
                                    ->label('عنوان البند (English)')
                                    ->placeholder('e.g. 1. Introduction'),
                            ]),
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\Textarea::make('body_ar')
                                    ->label('نص البند (عربي)')
                                    ->required()
                                    ->rows(3),
                                Forms\Components\Textarea::make('body_en')
                                    ->label('نص البند (English)')
                                    ->rows(3),
                            ]),
                        ])
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('banner_title_ar')->label('عنوان الصفحة'),
                Tables\Columns\TextColumn::make('last_updated')->label('آخر تحديث')->dateTime('Y-m-d')->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTermsOfUses::route('/'),
            'create' => Pages\CreateTermsOfUse::route('/create'),
            'edit'   => Pages\EditTermsOfUse::route('/{record}/edit'),
        ];
    }
}
