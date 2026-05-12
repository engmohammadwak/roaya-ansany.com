<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'الشركاء';
    protected static ?string $navigationGroup = 'إعدادات الموقع';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('name_ar')
                    ->label('الاسم (عربي)')->required(),
                Forms\Components\TextInput::make('name_en')
                    ->label('Name (English)'),
                Forms\Components\TextInput::make('icon')
                    ->label('أيقونة FontAwesome')
                    ->placeholder('fa-handshake')
                    ->helperText('تظهر عندما لا توجد صورة'),
                Forms\Components\ColorPicker::make('color')
                    ->label('لون خلفية المربع'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('الترتيب')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('مفعّل')->default(true),
            ]),
            Forms\Components\FileUpload::make('image')
                ->label('شعار الشريك (اختياري)')
                ->image()->directory('partners')
                ->helperText('إذا رفعت صورة ستظهر بدل الأيقونة')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#')->sortable(),
                Tables\Columns\ImageColumn::make('image')->label('الشعار')->circular(),
                Tables\Columns\TextColumn::make('name_ar')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('icon')->label('الأيقونة'),
                Tables\Columns\IconColumn::make('is_active')->label('مفعّل')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->label('آخر تعديل')->since(),
            ])
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('الحالة'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit'   => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
}
