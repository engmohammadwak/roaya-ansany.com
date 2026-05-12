<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutWorkFieldResource\Pages;
use App\Models\AboutWorkField;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutWorkFieldResource extends Resource
{
    protected static ?string $model = AboutWorkField::class;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'مجالات العمل';
    protected static ?string $navigationGroup = 'إدارة الصفحات';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('title_ar')->label('الاسم (عربي)')->required(),
                Forms\Components\TextInput::make('title_en')->label('الاسم (إنجليزي)'),
                Forms\Components\Textarea::make('description_ar')->label('الوصف (عربي)')->rows(3),
                Forms\Components\Textarea::make('description_en')->label('الوصف (إنجليزي)')->rows(3),
                Forms\Components\TextInput::make('icon')->label('الأيقونة (Emoji أو اسم)'),
                Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('icon')->label('أيقونة'),
            Tables\Columns\TextColumn::make('title_ar')->label('الاسم')->searchable(),
            Tables\Columns\TextColumn::make('sort_order')->label('الترتيب')->sortable(),
        ])
        ->reorderable('sort_order')
        ->defaultSort('sort_order')
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->headerActions([
            Tables\Actions\CreateAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAboutWorkFields::route('/'),
            'create' => Pages\CreateAboutWorkField::route('/create'),
            'edit'   => Pages\EditAboutWorkField::route('/{record}/edit'),
        ];
    }
}
