<?php
namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages;
use App\Models\Donation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class DonationResource extends Resource
{
    protected static ?string $model           = Donation::class;
    protected static ?string $navigationIcon  = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'التبرعات';
    protected static ?string $navigationGroup = 'المالية';
    protected static ?int    $navigationSort  = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::whereIn('status', ['success', 'completed'])->count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('بيانات المتبرع')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('اسم المتبرع')
                        ->disabled(),
                    Forms\Components\TextInput::make('email')
                        ->label('البريد الإلكتروني')
                        ->disabled(),
                ]),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('amount')
                        ->label('المبلغ')
                        ->disabled(),
                    Forms\Components\TextInput::make('currency')
                        ->label('العملة')
                        ->disabled(),
                    Forms\Components\TextInput::make('card_brand')
                        ->label('نوع البطاقة')
                        ->disabled(),
                ]),
                Forms\Components\TextInput::make('description')
                    ->label('الوصف')
                    ->disabled(),
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('transaction_id')
                        ->label('رقم العملية (transaction_id)')
                        ->disabled(),
                    Forms\Components\TextInput::make('gateway_ref')
                        ->label('مرجع البوابة (gateway_ref)')
                        ->disabled(),
                ]),
                Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending'   => 'معلق',
                        'success'   => 'نجح',
                        'completed' => 'مكتمل',
                        'failed'    => 'فشل',
                    ])
                    ->disabled(),
                Forms\Components\Textarea::make('gateway_data')
                    ->label('بيانات البوابة (JSON)')
                    ->disabled()
                    ->rows(5),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('المتبرع')
                    ->searchable()
                    ->default('—'),
                Tables\Columns\TextColumn::make('email')
                    ->label('البريد')
                    ->searchable()
                    ->default('—'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('المبلغ')
                    ->sortable()
                    ->formatStateUsing(fn($state, $record) => $record->currency . ' ' . number_format($state, 2)),
                Tables\Columns\TextColumn::make('campaign.title_ar')
                    ->label('الحملة')
                    ->default('عام'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'success' => fn($state) => in_array($state, ['success', 'completed']),
                        'danger'  => 'failed',
                        'warning' => 'pending',
                    ])
                    ->formatStateUsing(fn($state) => match($state) {
                        'success', 'completed' => 'نجح',
                        'failed'   => 'فشل',
                        default    => 'معلق',
                    }),
                Tables\Columns\TextColumn::make('card_brand')
                    ->label('بطاقة')
                    ->default('—'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending'   => 'معلق',
                        'success'   => 'نجح',
                        'completed' => 'مكتمل',
                        'failed'    => 'فشل',
                    ]),
            ])
            ->actions([Tables\Actions\ViewAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDonations::route('/'),
            'view'  => Pages\ViewDonation::route('/{record}'),
        ];
    }
}
