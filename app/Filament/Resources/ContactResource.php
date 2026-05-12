<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'الرسائل';
    protected static ?string $modelLabel = 'رسالة';
    protected static ?string $pluralModelLabel = 'الرسائل';
    protected static ?int $navigationSort = 5;
    protected static bool $canCreate = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('الاسم')->disabled(),
            Forms\Components\TextInput::make('email')->label('الإيميل')->disabled(),
            Forms\Components\TextInput::make('phone')->label('الهاتف')->disabled(),
            Forms\Components\Textarea::make('message')->label('الرسالة')->disabled()->rows(5)->columnSpanFull(),
            Forms\Components\Toggle::make('is_read')->label('مقروءة'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('الإيميل'),
                Tables\Columns\TextColumn::make('message')->label('الرسالة')->limit(50),
                Tables\Columns\IconColumn::make('is_read')->label('مقروءة')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('التاريخ')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'edit'  => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
