<?php
namespace App\Filament\Resources\PaymentGatewayResource\Pages;

use App\Filament\Resources\PaymentGatewayResource;
use App\Models\PaymobSetting;
use Filament\Resources\Pages\ListRecords;

class ListPaymentGateways extends ListRecords
{
    protected static string $resource = PaymentGatewayResource::class;

    public function mount(): void
    {
        $record = PaymobSetting::first();
        if ($record) {
            $this->redirect(PaymentGatewayResource::getUrl('edit', ['record' => $record->id]));
        } else {
            $this->redirect(PaymentGatewayResource::getUrl('create'));
        }
    }
}
