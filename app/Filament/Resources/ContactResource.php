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
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;

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

    // ── Infolist (view page) ──
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('بيانات المرسل')
                ->schema([
                    TextEntry::make('first_name')->label('الاسم الأول'),
                    TextEntry::make('last_name')->label('اسم العائلة'),
                    TextEntry::make('email')->label('البريد الإلكتروني')
                        ->copyable(),
                    TextEntry::make('phone')->label('رقم الموبايل')
                        ->copyable(),
                    TextEntry::make('created_at')->label('تاريخ الإرسال')
                        ->dateTime(),
                    IconEntry::make('is_read')->label('حالة القراءة')
                        ->boolean()
                        ->trueIcon('heroicon-o-check-circle')
                        ->falseIcon('heroicon-o-x-circle')
                        ->trueColor('success')
                        ->falseColor('danger'),
                ])->columns(2),

            Section::make('نص الرسالة')
                ->schema([
                    TextEntry::make('message')->label('')
                        ->columnSpanFull()
                        ->prose(),
                ]),
        ]);
    }

    // ── Form (edit) ──
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('بيانات المرسل')
                ->schema([
                    Forms\Components\TextInput::make('first_name')->label('الاسم الأول')->disabled()->dehydrated(false),
                    Forms\Components\TextInput::make('last_name')->label('اسم العائلة')->disabled()->dehydrated(false),
                    Forms\Components\TextInput::make('email')->label('البريد')->disabled()->dehydrated(false),
                    Forms\Components\TextInput::make('phone')->label('الموبايل')->disabled()->dehydrated(false),
                ])->columns(2),

            Forms\Components\Section::make('نص الرسالة')
                ->schema([
                    Forms\Components\Textarea::make('message')->label('')
                        ->disabled()->dehydrated(false)
                        ->rows(6)->columnSpanFull(),
                ]),

            Forms\Components\Section::make('حالة القراءة')
                ->schema([
                    Forms\Components\Toggle::make('is_read')
                        ->label('تم القراءة')
                        ->onColor('success')
                        ->offColor('danger')
                        ->onIcon('heroicon-m-check')
                        ->offIcon('heroicon-m-x-mark')
                        ->inline(false),
                ]),
        ]);
    }

    // ── Table ──
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('الاسم')
                    ->getStateUsing(fn ($record) => trim(($record->first_name ?? $record->name ?? '') . ' ' . ($record->last_name ?? '')))
                    ->searchable(query: fn ($query, $search) => $query
                        ->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%")
                    ),
                Tables\Columns\TextColumn::make('email')->label('البريد')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('phone')->label('الموبايل'),
                Tables\Columns\TextColumn::make('message')->label('الرسالة')->limit(60),
                Tables\Columns\IconColumn::make('is_read')->label('مقروء')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('created_at')->label('التاريخ')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('is_read')->label('الحالة')
                    ->trueLabel('مقروء')->falseLabel('غير مقروء'),
            ])
            ->actions([
                Tables\Actions\Action::make('toggleRead')
                    ->label(fn (Contact $r) => $r->is_read ? 'تحديد كغير مقروء' : 'تحديد كمقروء')
                    ->icon(fn (Contact $r) => $r->is_read ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (Contact $r) => $r->is_read ? 'warning' : 'success')
                    ->action(fn (Contact $r) => $r->update(['is_read' => !$r->is_read])),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('markAllRead')
                        ->label('تحديد الكل كمقروء')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_read' => true])),
                    Tables\Actions\BulkAction::make('markAllUnread')
                        ->label('تحديد الكل كغير مقروء')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->update(['is_read' => false])),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'view'  => Pages\ViewContact::route('/{record}'),
            'edit'  => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
