<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'رسائل التواصل';
    protected static ?string $navigationGroup = 'إدارة الصفحات';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('name')->label('الاسم')->disabled(),
                Forms\Components\TextInput::make('email')->label('البريد')->disabled(),
                Forms\Components\TextInput::make('subject')->label('الموضوع')->disabled(),
                Forms\Components\Toggle::make('is_read')->label('تم القراءة'),
            ]),
            Forms\Components\Textarea::make('message')->label('الرسالة')->disabled()->rows(6)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable(),
            Tables\Columns\TextColumn::make('email')->label('البريد')->searchable(),
            Tables\Columns\TextColumn::make('subject')->label('الموضوع')->limit(40),
            Tables\Columns\IconColumn::make('is_read')->label('مقروءة')->boolean(),
            Tables\Columns\TextColumn::make('created_at')->label('التاريخ')->dateTime('Y-m-d H:i')->sortable(),
        ])->defaultSort('created_at','desc')
          ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\DeleteAction::make(),
          ]);
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'view'  => Pages\ViewContactMessage::route('/{record}'),
        ];
    }
}
