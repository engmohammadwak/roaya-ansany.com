<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\TernaryFilter;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    protected static ?string $navigationIcon  = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'الرسائل';
    protected static ?string $navigationLabel = 'رسائل التواصل';
    protected static ?int    $navigationSort  = 1;

    public static function getNavigationBadge(): ?string {
        return (string) Contact::where('is_read', false)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('first_name')->label('الاسم الأول')->disabled(),
            Forms\Components\TextInput::make('last_name')->label('اسم العائلة')->disabled(),
            Forms\Components\TextInput::make('email')->label('البريد')->disabled(),
            Forms\Components\TextInput::make('phone')->label('الموبايل')->disabled(),
            Forms\Components\Textarea::make('message')->label('الرسالة')->disabled()->rows(5)->columnSpanFull(),
            Forms\Components\Toggle::make('is_read')->label('تم القراءة'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label('الاسم')
                    ->formatStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')->label('البريد')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('الموبايل'),
                Tables\Columns\TextColumn::make('message')->label('الرسالة')->limit(60),
                Tables\Columns\IconColumn::make('is_read')->label('مقروء')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label('التاريخ')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('is_read')->label('الحالة')
                    ->trueLabel('مقروء')->falseLabel('غير مقروء'),
            ])
            ->actions([
                Tables\Actions\Action::make('markRead')
                    ->label('تحديد كمقروء')
                    ->icon('heroicon-o-check')
                    ->action(fn (Contact $record) => $record->update(['is_read' => true]))
                    ->visible(fn (Contact $record) => !$record->is_read),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('markAllRead')
                        ->label('تحديد الكل كمقروء')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_read' => true])),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'view'  => Pages\ViewContact::route('/{record}'),
        ];
    }
}
