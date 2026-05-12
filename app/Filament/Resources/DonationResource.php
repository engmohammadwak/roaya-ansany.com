<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages;
use App\Models\Donation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'التبرعات';
    protected static ?string $modelLabel = 'تبرع';
    protected static ?string $pluralModelLabel = 'التبرعات';
    protected static ?int $navigationSort = 4;
    protected static bool $canCreate = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('campaign_id')->label('الحملة')->relationship('campaign', 'title_ar'),
            Forms\Components\TextInput::make('name')->label('الاسم'),
            Forms\Components\TextInput::make('email')->label('الإيميل'),
            Forms\Components\TextInput::make('phone')->label('الهاتف'),
            Forms\Components\TextInput::make('amount')->label('المبلغ')->numeric(),
            Forms\Components\Select::make('status')->label('الحالة')
                ->options(['pending' => 'قيد الانتظار', 'completed' => 'مكتمل', 'failed' => 'فشل']),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('campaign.title_ar')->label('الحملة'),
                Tables\Columns\TextColumn::make('amount')->label('المبلغ')->money('USD'),
                Tables\Columns\BadgeColumn::make('status')->label('الحالة')
                    ->colors(['warning' => 'pending', 'success' => 'completed', 'danger' => 'failed']),
                Tables\Columns\TextColumn::make('created_at')->label('التاريخ')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDonations::route('/'),
            'edit'  => Pages\EditDonation::route('/{record}/edit'),
        ];
    }
}
