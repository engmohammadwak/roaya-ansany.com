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

            // ── Status & Mode ──
            Forms\Components\Section::make('حالة بوابة Paymob')
                ->description('تحكم تفعيل البوابة ووضع الاختبار')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('تفعيل البوابة')
                            ->helperText('عند التعطيل تذهب جميع المدفوعات لوضع التست')
                            ->live(),
                        Forms\Components\Toggle::make('test_mode')
                            ->label('وضع الاختبار (Test Mode)')
                            ->helperText('يقبل الدفع محاكاة دون Paymob — كل عملية تُسجّل بحالة نجاح')
                            ->default(true),
                    ]),
                ]),

            // ── Server / Region ──
            Forms\Components\Section::make('إعدادات Paymob')
                ->description('احصل على هذه المفاتيح من Paymob Dashboard → Settings → Account Info')
                ->schema([
                    Forms\Components\Select::make('base_url')
                        ->label('المنطقة / الخادم')
                        ->options([
                            'https://accept.paymob.com' => 'مصر — accept.paymob.com',
                            'https://oman.paymob.com'   => 'عُمان — oman.paymob.com',
                            'https://ksa.paymob.com'    => 'السعودية — ksa.paymob.com',
                            'https://uae.paymob.com'    => 'الإمارات — uae.paymob.com',
                        ])
                        ->default('https://accept.paymob.com')
                        ->required(),

                    Forms\Components\Grid::make(1)->schema([
                        Forms\Components\Textarea::make('secret_key')
                            ->label('المفتاح السري (Secret Key)')
                            ->rows(2)
                            ->placeholder('sk_...')
                            ->helperText('\u064a\u064f\u0633\u062a\u062e\u062f\u0645 \u0644\u0625\u0646\u0634\u0627\u0621 ا\u0644\u0625\u064a\u062f\u0627\u0639 (Intention API) \u2014 \u0644\u0627 \u062a\u0634\u0627\u0631\u0643\u0647 \u0645\u0639 \u0623\u062d\u062f'),
                    ]),

                    Forms\Components\TextInput::make('public_key')
                        ->label('المفتاح العام (Public Key)')
                        ->placeholder('pk_...')
                        ->helperText('ي\u064f\u0631\u0633\u0644 \u0645\u0639 \u0631ا\u0628\u0637 ا\u0644\u062f\u0641\u0639 ا\u0644\u0645\u0648\u062d\u062f (Unified Checkout)'),

                    Forms\Components\TextInput::make('integration_id')
                        ->label('Integration ID')
                        ->placeholder('123456')
                        ->helperText('من Paymob Dashboard → Developers → Payment Integrations'),

                    Forms\Components\TextInput::make('hmac_secret')
                        ->label('HMAC Secret')
                        ->password()
                        ->revealable()
                        ->helperText('ل\u0644\u062a\u062d\u0642\u0642 \u0645\u0646 \u0635\u062d\u0629 Webhook — \u0627\u062e\u062a\u064a\u0627\u0631\u064a'),
                ]),

            // ── URLs ──
            Forms\Components\Section::make('روابط الرجوع')
                ->description('إذا تركتها فارغة يستخدم النظام الروابط التلقائية')
                ->schema([
                    Forms\Components\TextInput::make('callback_url')
                        ->label('Webhook / Notification URL')
                        ->placeholder('https://yoursite.com/ar/donate/payment/callback')
                        ->helperText('الرابط الذي يرسل إليه Paymob بعد كل عملية'),
                    Forms\Components\TextInput::make('redirect_url')
                        ->label('Redirection URL (بعد الدفع)')
                        ->placeholder('https://yoursite.com/ar/donate/payment/result')
                        ->helperText('يُعاد العميل إليه بعد إتمام الدفع'),
                ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_active')->label('مفعلة')->boolean(),
                Tables\Columns\IconColumn::make('test_mode')->label('وضع التست')->boolean(),
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
