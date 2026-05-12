<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PaymentGatewayResource\Pages;
use App\Models\PaymobSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentGatewayResource extends Resource
{
    protected static ?string $model           = PaymobSetting::class;
    protected static ?string $navigationIcon  = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'بوابة الدفع';
    protected static ?string $navigationGroup = 'الإعدادات';
    protected static ?int    $navigationSort  = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('حالة البوابة')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('تفعيل بوابة الدفع')
                            ->helperText('عند التعطيل لا يستطيع الزوار الدفع'),
                        Forms\Components\Toggle::make('test_mode')
                            ->label('وضع الاختبار (Test Mode)')
                            ->helperText('في وضع الاختبار يتم قبول الدفع دون بوابة حقيقية')
                            ->default(true),
                    ]),
                ]),

            Forms\Components\Section::make('بيانات Paymob')
                ->description('احصل على هذه البيانات من لوحة تحكم Paymob')
                ->schema([
                    Forms\Components\Select::make('base_url')
                        ->label('الخادم')
                        ->options([
                            'https://accept.paymob.com' => 'مصر (EGY)',
                            'https://oman.paymob.com'   => 'عُمان (OMN)',
                            'https://ksa.paymob.com'    => 'السعودية (KSA)',
                            'https://uae.paymob.com'    => 'الإمارات (UAE)',
                        ])
                        ->default('https://accept.paymob.com')
                        ->required(),
                    Forms\Components\Textarea::make('api_key')
                        ->label('API Key')
                        ->rows(3)
                        ->placeholder('ZXlKaGJHY2lPaUpJVXpVeM...')
                        ->helperText('من لوحة Paymob: Settings → Account Info → API Key'),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('integration_id')
                            ->label('Integration ID')
                            ->placeholder('123456'),
                        Forms\Components\TextInput::make('iframe_id')
                            ->label('iFrame ID')
                            ->placeholder('78910'),
                    ]),
                    Forms\Components\TextInput::make('hmac_secret')
                        ->label('HMAC Secret')
                        ->password()
                        ->revealable()
                        ->placeholder('...'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_active')->label('مفعلة')->boolean(),
                Tables\Columns\IconColumn::make('test_mode')->label('تست')->boolean(),
                Tables\Columns\TextColumn::make('base_url')->label('الخادم'),
                Tables\Columns\TextColumn::make('updated_at')->label('آخر تحديث')->dateTime('Y-m-d H:i'),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPaymentGateways::route('/'),
            'create' => Pages\CreatePaymentGateway::route('/create'),
            'edit'   => Pages\EditPaymentGateway::route('/{record}/edit'),
        ];
    }
}
